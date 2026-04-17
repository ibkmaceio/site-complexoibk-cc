# Podcast Modal + Auto-update Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Permitir assistir podcasts via modal na homepage, com auto-seleção do episódio mais recente a cada rebuild diário.

**Architecture:** `VideosSection.tsx` vira Client Component com estado de modal inline; `fetch-videos.mjs` sempre usa `podcasts[0]` como destaque; `videos.json` removido o campo `pinnedPodcastId`; cron de rebuild atualizado para diário.

**Tech Stack:** Next.js 16 (static export), React 19, TypeScript, Tailwind CSS v4

**Spec:** `docs/superpowers/specs/2026-04-13-podcast-modal-autoupdate-design.md`

---

## Mapa de arquivos

| Arquivo | Ação | Responsabilidade |
|---|---|---|
| `src/lib/data/videos.json` | Modificar | Inserir `VOOwK7csjxM` em `podcasts[0]`, remover `pinnedPodcastId` |
| `scripts/fetch-videos.mjs` | Modificar | Remover lógica de preservação de `pinnedPodcastId` |
| `src/components/sections/VideosSection.tsx` | Modificar | Client Component + modal inline + usar `podcasts[0]` direto |
| `.github/workflows/deploy.yml` | Modificar | Cron diário `"0 9 * * *"` |

---

## Task 1: Atualizar `videos.json`

**Files:**
- Modify: `src/lib/data/videos.json`

- [ ] **Step 1: Substituir o conteúdo completo do arquivo**

Conteúdo final (remove `pinnedPodcastId`, insere `VOOwK7csjxM` como primeiro podcast, mantém 5 entradas):

```json
{
  "ibk": [
    {
      "id": "mvILffB2f5A",
      "titulo": "Seja bem-vindo à IBK Maceió. Inscreva-se no canal e acompanhe tudo o que Deus tem feito entre nós.",
      "data": "2026-04-12",
      "thumbnail": "https://i.ytimg.com/vi/mvILffB2f5A/hqdefault.jpg"
    },
    {
      "id": "VOOwK7csjxM",
      "titulo": "O que fazer quando Deus está em silêncio | IBKAST EP 04",
      "data": "2026-04-10",
      "thumbnail": "https://i.ytimg.com/vi/VOOwK7csjxM/hqdefault.jpg"
    },
    {
      "id": "vvKS_TfaDYQ",
      "titulo": "Culto da Palavra | 08.04",
      "data": "2026-04-09",
      "thumbnail": "https://i.ytimg.com/vi/vvKS_TfaDYQ/hqdefault.jpg"
    },
    {
      "id": "cKQm3Zat4yI",
      "titulo": "Culto Doutrinário | 05.04",
      "data": "2026-04-06",
      "thumbnail": "https://i.ytimg.com/vi/cKQm3Zat4yI/hqdefault.jpg"
    },
    {
      "id": "msSYzu7pjkI",
      "titulo": "Auto de Páscoa e Ceia do Senhor | 05.04",
      "data": "2026-04-05",
      "thumbnail": "https://i.ytimg.com/vi/msSYzu7pjkI/hqdefault.jpg"
    }
  ],
  "pedro": [
    {
      "id": "6Ynjx-Z3Ixg",
      "titulo": "Misericórdia do Pai Lc 6.36",
      "data": "2026-04-11",
      "thumbnail": "https://i.ytimg.com/vi/6Ynjx-Z3Ixg/hqdefault.jpg"
    },
    {
      "id": "nNqJd3ZbmnI",
      "titulo": "Orar para decidir Lc 6.12,13",
      "data": "2026-04-07",
      "thumbnail": "https://i.ytimg.com/vi/nNqJd3ZbmnI/hqdefault.jpg"
    },
    {
      "id": "nAfkBLwf67k",
      "titulo": "De olho nos perdidos Lc 5.31",
      "data": "2026-04-07",
      "thumbnail": "https://i.ytimg.com/vi/nAfkBLwf67k/hqdefault.jpg"
    },
    {
      "id": "SsduBoz7UQ0",
      "titulo": "Sábia obediência Lc 5.5",
      "data": "2026-04-04",
      "thumbnail": "https://i.ytimg.com/vi/SsduBoz7UQ0/hqdefault.jpg"
    },
    {
      "id": "yMVdc5tRMm0",
      "titulo": "Foco na comunhão Lc 4.42-43",
      "data": "2026-04-02",
      "thumbnail": "https://i.ytimg.com/vi/yMVdc5tRMm0/hqdefault.jpg"
    }
  ],
  "podcasts": [
    {
      "id": "VOOwK7csjxM",
      "titulo": "O que fazer quando Deus está em silêncio | IBKAST EP 04",
      "data": "2026-04-10",
      "thumbnail": "https://i.ytimg.com/vi/VOOwK7csjxM/hqdefault.jpg"
    },
    {
      "id": "r2WwnnNH6R8",
      "titulo": "Deus escolheu agir através de pessoas imperfeitas",
      "data": "2026-03-30",
      "thumbnail": "https://i.ytimg.com/vi/r2WwnnNH6R8/hqdefault.jpg"
    },
    {
      "id": "1UL5yAy8_2U",
      "titulo": "A verdade sobre propósito que ninguém te contou | IBKAST EP 03",
      "data": "2026-03-19",
      "thumbnail": "https://i.ytimg.com/vi/1UL5yAy8_2U/hqdefault.jpg"
    },
    {
      "id": "3_DNtAuFWHQ",
      "titulo": "Casamento, igreja e chamado pastoral | IBKAST EP 02",
      "data": "2026-03-13",
      "thumbnail": "https://i.ytimg.com/vi/3_DNtAuFWHQ/hqdefault.jpg"
    },
    {
      "id": "sCk__3GN-lU",
      "titulo": "Os perigos da liderança sem vida com Deus | Pr. Pedro Luz e Pr. Raphael Abdalla - Ep.01",
      "data": "2026-03-06",
      "thumbnail": "https://i.ytimg.com/vi/sCk__3GN-lU/hqdefault.jpg"
    }
  ],
  "updatedAt": "2026-04-13T09:00:00.000Z"
}
```

- [ ] **Step 2: Verificar que o JSON é válido**

```bash
node -e "JSON.parse(require('fs').readFileSync('src/lib/data/videos.json','utf8')); console.log('OK')"
```

Esperado: `OK`

- [ ] **Step 3: Commit**

```bash
cd /Users/ismaelfilho/Downloads/site-complexoibk-cc/root
rtk git add src/lib/data/videos.json
rtk git commit -m "data: atualiza podcast destaque para EP04 e remove pinnedPodcastId"
```

---

## Task 2: Atualizar `fetch-videos.mjs`

**Files:**
- Modify: `scripts/fetch-videos.mjs`

- [ ] **Step 1: Substituir o bloco de montagem de `data` no try**

Localizar este trecho (linhas ~60-70 do arquivo):

```js
  // Preserva o pinnedPodcastId definido manualmente
  const existing = existsSync(OUTPUT)
    ? JSON.parse(readFileSync(OUTPUT, "utf8"))
    : {};

  const data = {
    ibk: ibk.slice(0, 5),
    pedro: pedro.slice(0, 5),
    pinnedPodcastId: existing.pinnedPodcastId ?? podcasts[0]?.id ?? "",
    podcasts: podcasts.slice(0, 5),
    updatedAt: new Date().toISOString(),
  };
```

Substituir por:

```js
  const data = {
    ibk: ibk.slice(0, 5),
    pedro: pedro.slice(0, 5),
    podcasts: podcasts.slice(0, 5),
    updatedAt: new Date().toISOString(),
  };
```

Remover também os imports de `existsSync` e `readFileSync` se ficarem sem uso. Verificar a linha de imports no topo do arquivo:

```js
import { writeFileSync, existsSync, readFileSync } from "fs";
```

Substituir por:

```js
import { writeFileSync } from "fs";
```

- [ ] **Step 2: Testar o script manualmente**

```bash
cd /Users/ismaelfilho/Downloads/site-complexoibk-cc/root
node scripts/fetch-videos.mjs
```

Esperado (com rede disponível):
```
Buscando videos do YouTube...
TV IBK: 5 | Pedro Luz: 5 | Podcasts: 5
```

Se sem rede: `Sem rede - usando videos.json existente.` — também é aceitável.

- [ ] **Step 3: Verificar que `pinnedPodcastId` não está no JSON gerado**

```bash
node -e "const d = JSON.parse(require('fs').readFileSync('src/lib/data/videos.json','utf8')); console.log('pinnedPodcastId' in d ? 'ERRO: campo ainda existe' : 'OK: campo removido')"
```

Esperado: `OK: campo removido`

- [ ] **Step 4: Commit**

```bash
rtk git add scripts/fetch-videos.mjs
rtk git commit -m "feat: fetch-videos sempre usa podcasts[0] como destaque, remove pinnedPodcastId"
```

---

## Task 3: Refatorar `VideosSection.tsx` com modal

**Files:**
- Modify: `src/components/sections/VideosSection.tsx`

- [ ] **Step 1: Substituir o arquivo completo**

```tsx
"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { ArrowRight, X } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";
import videosData from "@/lib/data/videos.json";

const ALL = videosData.podcasts;
const principal = ALL[0];
const laterais = ALL.slice(1);
const PLAYLIST_URL = "https://www.youtube.com/playlist?list=PLW0VOn2DYtJ5JOiu83F2IJJ6Bnh8Yq87-";

interface VideoEntry {
  id: string;
  titulo: string;
  data: string;
  thumbnail: string;
}

function formatDate(dateStr: string) {
  return new Date(dateStr).toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  });
}

export default function VideosSection() {
  const [openVideo, setOpenVideo] = useState<VideoEntry | null>(null);

  // Bloqueia scroll do body enquanto modal está aberto
  useEffect(() => {
    if (openVideo) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
    return () => {
      document.body.style.overflow = "";
    };
  }, [openVideo]);

  // Fecha modal ao pressionar ESC
  useEffect(() => {
    const handler = (e: KeyboardEvent) => {
      if (e.key === "Escape") setOpenVideo(null);
    };
    document.addEventListener("keydown", handler);
    return () => document.removeEventListener("keydown", handler);
  }, []);

  return (
    <>
      <section className="bg-ibk-dark-surface py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10">
        <div className="max-w-7xl mx-auto">

          {/* Header */}
          <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16">
            <FadeIn>
              <div>
                <div className="flex items-center gap-3 mb-4">
                  <span className="w-6 h-px bg-[#E84C1E]" />
                  <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                    {COPY.tvIbk.eyebrow}
                  </span>
                </div>
                <h2 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight tracking-tight">
                  {COPY.tvIbk.headline}
                </h2>
              </div>
            </FadeIn>

            <FadeIn delay={0.1}>
              <a
                href={PLAYLIST_URL}
                target="_blank"
                rel="noopener noreferrer"
                className="flex items-center gap-2 text-white/65 hover:text-white font-display font-bold text-sm transition-colors group shrink-0"
              >
                {COPY.tvIbk.cta}
                <ArrowRight size={15} className="group-hover:translate-x-1 transition-transform" />
              </a>
            </FadeIn>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {/* Vídeo principal */}
            <FadeIn className="lg:col-span-7">
              <button
                type="button"
                onClick={() => setOpenVideo(principal)}
                className="group block w-full text-left"
              >
                <div className="relative aspect-video bg-ibk-dark-card rounded overflow-hidden">
                  <img
                    src={principal.thumbnail}
                    alt={principal.titulo}
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                  />
                  <div className="absolute inset-0 bg-black/15 group-hover:bg-black/0 transition-colors" />
                  {/* Play button */}
                  <div className="absolute inset-0 flex items-center justify-center">
                    <div className="w-18 h-18 flex items-center justify-center rounded-full border-2 border-white/80 bg-black/25 backdrop-blur-sm transition-all group-hover:bg-[#E84C1E] group-hover:border-[#E84C1E] group-hover:scale-110">
                      <svg width="28" height="28" viewBox="0 0 24 24" fill="white" className="ml-1">
                        <polygon points="5 3 19 12 5 21 5 3" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div className="mt-4 px-1">
                  <h3 className="font-display font-extrabold text-lg text-white leading-snug group-hover:text-[#E84C1E] transition-colors">
                    {principal.titulo}
                  </h3>
                  <p className="text-white/65 font-body text-xs mt-1">
                    {formatDate(principal.data)}
                  </p>
                </div>
              </button>
            </FadeIn>

            {/* Laterais */}
            <div className="lg:col-span-5 flex flex-col justify-between gap-5">
              {laterais.slice(0, 4).map((v, i) => (
                <FadeIn key={v.id} delay={i * 0.08} direction="left">
                  <button
                    type="button"
                    onClick={() => setOpenVideo(v)}
                    className="group flex gap-4 items-start w-full text-left"
                  >
                    <div className="relative w-32 aspect-video bg-ibk-dark-card rounded overflow-hidden shrink-0">
                      <img
                        src={v.thumbnail}
                        alt={v.titulo}
                        className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                      />
                      <div className="absolute inset-0 flex items-center justify-center bg-black/10 group-hover:bg-black/0 transition-colors">
                        <div className="w-7 h-7 flex items-center justify-center rounded-full bg-[#E84C1E]/90">
                          <svg width="10" height="10" viewBox="0 0 24 24" fill="white" className="ml-0.5">
                            <polygon points="5 3 19 12 5 21 5 3" />
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div className="flex-1 pt-1">
                      <h4 className="font-display font-bold text-sm text-white/90 leading-snug line-clamp-2 group-hover:text-white transition-colors">
                        {v.titulo}
                      </h4>
                      <p className="text-white/65 font-body text-xs mt-1.5">
                        {formatDate(v.data)}
                      </p>
                    </div>
                  </button>
                </FadeIn>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Modal de vídeo */}
      {openVideo && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4"
          onClick={() => setOpenVideo(null)}
        >
          <div
            className="relative w-full max-w-4xl"
            onClick={(e) => e.stopPropagation()}
          >
            <button
              type="button"
              className="absolute -top-10 right-0 text-white/80 hover:text-white transition-colors"
              onClick={() => setOpenVideo(null)}
              aria-label="Fechar"
            >
              <X size={24} />
            </button>
            <div className="relative w-full aspect-video">
              <iframe
                src={`https://www.youtube.com/embed/${openVideo.id}?autoplay=1`}
                allow="autoplay; fullscreen; picture-in-picture"
                allowFullScreen
                className="w-full h-full rounded"
                title={openVideo.titulo}
              />
            </div>
            <div className="mt-3 px-1">
              <h3 className="font-display font-bold text-white text-base leading-snug">
                {openVideo.titulo}
              </h3>
              <p className="text-white/65 font-body text-xs mt-1">
                {formatDate(openVideo.data)}
              </p>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
```

- [ ] **Step 2: Verificar TypeScript**

```bash
cd /Users/ismaelfilho/Downloads/site-complexoibk-cc/root
rtk tsc --noEmit
```

Esperado: sem erros.

- [ ] **Step 3: Rodar build completo**

```bash
npm run build
```

Esperado: build concluído sem erros. O script `fetch-videos.mjs` roda antes do Next.js build.

- [ ] **Step 4: Testar no browser**

```bash
npm run dev
```

Abrir `http://localhost:3000` e verificar:
- Card principal mostra "O que fazer quando Deus está em silêncio | IBKAST EP 04"
- Clicar no card principal → modal abre com iframe do YouTube
- Clicar nos cards laterais → modal abre
- Clicar fora do player → modal fecha
- Pressionar ESC → modal fecha
- Botão X → modal fecha
- Scroll do body bloqueado enquanto modal está aberto
- Título e data do episódio aparecem abaixo do player no modal

- [ ] **Step 5: Commit**

```bash
rtk git add src/components/sections/VideosSection.tsx
rtk git commit -m "feat: podcast modal com player embutido e auto-selecao do episodio mais recente"
```

---

## Task 4: Atualizar cron de rebuild para diário

**Files:**
- Modify: `.github/workflows/deploy.yml`

- [ ] **Step 1: Alterar o cron no `deploy.yml`**

Localizar:

```yaml
    # Toda segunda, quarta e sexta às 9h UTC (6h de Maceió)
    - cron: "0 9 * * 1,3,5"
```

Substituir por:

```yaml
    # Todo dia às 9h UTC (6h de Maceió)
    - cron: "0 9 * * *"
```

- [ ] **Step 2: Commit**

```bash
rtk git add .github/workflows/deploy.yml
rtk git commit -m "ci: rebuild diario para atualizar episodios de podcast automaticamente"
```

---

## Self-Review

**Cobertura do spec:**
- [x] Modal abre ao clicar no card principal → Task 3 (`button onClick` no `principal`)
- [x] Modal abre ao clicar nos cards laterais → Task 3 (`button onClick` em `laterais`)
- [x] Player embutido com autoplay → Task 3 (iframe `?autoplay=1`)
- [x] Título e data no modal → Task 3 (bloco abaixo do iframe)
- [x] Fechar com ESC → Task 3 (`useEffect` keydown)
- [x] Fechar clicando fora → Task 3 (`onClick` no overlay)
- [x] Fechar com botão X → Task 3 (botão com `X` de lucide)
- [x] Scroll do body bloqueado → Task 3 (`useEffect` overflow)
- [x] Remove `pinnedPodcastId` do JSON → Task 1
- [x] Remove `pinnedPodcastId` do script → Task 2
- [x] `fetch-videos.mjs` usa `podcasts[0]` → Task 2 (remoção da preservação)
- [x] `VOOwK7csjxM` como destaque imediato → Task 1 (`podcasts[0]`)
- [x] Rebuild diário → Task 4

**Placeholder scan:** Nenhum TBD ou TODO encontrado.

**Consistência de tipos:** `VideoEntry` definida em Task 3 e usada no mesmo arquivo. `openVideo: VideoEntry | null` — consistente com `setOpenVideo(principal)` e `setOpenVideo(v)` onde ambos são do array `ALL: VideoEntry[]` inferido do JSON.
