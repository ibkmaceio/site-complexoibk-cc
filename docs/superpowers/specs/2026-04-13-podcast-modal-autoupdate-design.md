# Design: Podcast Modal + Auto-update

**Data:** 2026-04-13  
**Status:** Aprovado (revisado com melhorias)

---

## Objetivo

1. Permitir assistir episódios de podcast diretamente na homepage (modal com player embutido do YouTube), sem abrir nova aba.
2. Atualizar automaticamente o vídeo principal para o episódio mais recente sempre que um novo for publicado na playlist do YouTube.
3. Atualizar imediatamente o vídeo destaque para `VOOwK7csjxM`.

---

## Escopo

- Arquivo modificado: `src/components/sections/VideosSection.tsx`
- Arquivo modificado: `scripts/fetch-videos.mjs`
- Arquivo modificado: `src/lib/data/videos.json`
- Arquivo modificado: `.github/workflows/deploy.yml`
- Nenhum novo componente criado (modal inline na seção)
- Nenhuma nova dependência

---

## 1. Modal de Vídeo

### Comportamento

- Ao clicar em **qualquer** card de podcast — tanto o `principal` (card grande) quanto os `laterais` — abre um overlay em tela cheia com `<iframe>` do YouTube embutido.
- O player inicia com autoplay (`autoplay=1`).
- Abaixo do player: título e data do episódio clicado.
- O modal fecha ao:
  - Clicar fora do player (no fundo escuro)
  - Pressionar `ESC`
  - Clicar no botão X

### Implementação

- `VideosSection.tsx` passa de Server Component para Client Component (`"use client"`).
- Estado: `const [openVideo, setOpenVideo] = useState<{ id: string; titulo: string; data: string } | null>(null)`.
- Quando `openVideo !== null`, renderiza o overlay.
- **Scroll do body:** ao abrir modal, `document.body.style.overflow = 'hidden'`; ao fechar, restaurar `''`. Gerenciado via `useEffect` com cleanup.
- **Listener de ESC:** `useEffect` com `addEventListener('keydown', ...)`, removido no cleanup.
- Overlay: `position: fixed`, `inset: 0`, `z-50`, fundo `bg-black/80`, flex center.
- Container do player: `max-w-4xl`, centralizado, `stopPropagation` no click para não fechar ao clicar no player.
- Iframe: `src="https://www.youtube.com/embed/{openVideo.id}?autoplay=1"`, `allow="autoplay; fullscreen"`, aspect-ratio 16/9, `w-full`.
- Abaixo do iframe: título em branco (`font-display font-bold`) e data formatada (`text-white/65 text-xs`).
- Botão X: canto superior direito do container, aria-label="Fechar".
- Clicar no fundo overlay fecha; clicar no container do player não fecha.

### Cards modificados

- **Card principal (`principal`):** remover `<a href>`, transformar em `<button>` ou `<div onClick>` que chama `setOpenVideo({ id: principal.id, titulo: principal.titulo, data: principal.data })`.
- **Cards laterais (`laterais`):** mesma mudança — `<a href>` → clicável que abre modal.

---

## 2. Simplificação do `pinnedPodcastId`

### Problema atual

O campo `pinnedPodcastId` existe em `videos.json` e é preservado manualmente em `fetch-videos.mjs`. Com o novo comportamento (sempre mostrar o mais recente), ele é desnecessário.

### Solução

- Remover `pinnedPodcastId` do `videos.json` e do `fetch-videos.mjs`.
- `VideosSection.tsx` passa a usar diretamente `podcasts[0]` como vídeo principal — sem lógica de `find` por ID.
- Simplifica o código e elimina uma fonte de confusão futura.

---

## 3. Auto-update: Rebuild Diário

### Problema atual

O `deploy.yml` agenda rebuild seg/qua/sex — episódio publicado na quinta só aparece na sexta.

### Solução

Mudar o cron de `"0 9 * * 1,3,5"` para `"0 9 * * *"` (todos os dias às 9h UTC / 6h Maceió). Atraso máximo: 1 dia.

---

## 4. Atualização Imediata

- Remover `pinnedPodcastId` de `src/lib/data/videos.json`.
- Garantir que `podcasts[0]` seja `VOOwK7csjxM` — já está na posição correta no JSON atual? **Não**: atualmente `podcasts[0].id = "r2WwnnNH6R8"`. O episódio `VOOwK7csjxM` está em `videos.json` mas na chave `ibk`, não em `podcasts`.
- Portanto: adicionar `VOOwK7csjxM` como primeiro item de `podcasts` em `videos.json` com título e data corretos, empurrando os demais para baixo (manter apenas 5 no total).

---

## Fluxo de dados

```
YouTube RSS (playlist podcasts)
        ↓ (build time, via fetch-videos.mjs — diário)
videos.json.podcasts[0] = episódio mais recente
        ↓ (lido em build time pelo Next.js)
VideosSection ("use client")
        ↓ (interação do usuário — click no card)
Modal overlay
  ├── iframe YouTube embutido (autoplay)
  └── título + data do episódio
```

---

## Não está no escopo

- Página `/podcasts/` completa (continua "Em Breve")
- Deep linking por URL para um episódio específico
- Focus trap completo (WCAG AA) no modal
- Loading skeleton enquanto iframe carrega
