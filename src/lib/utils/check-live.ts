// Detecção de transmissão ao vivo do canal IBK Maceió no YouTube.
// Compartilhado entre HeroSection (CTA destacado) e AoVivoPlayer (player principal).

const CHANNEL_ID = "UCRdiHrr_rVcJoxfv62QAYTw";
const API_KEY = process.env.NEXT_PUBLIC_YOUTUBE_API_KEY;
const CACHE_KEY = "ibk_live_check_v1";
const CACHE_TTL_MS = 2 * 60 * 1000;

const COMPLETED_CACHE_KEY = "ibk_last_completed_v1";
const COMPLETED_TTL_MS = 3 * 60 * 1000;

// Retry pós-live: 10 min, intervalo 3 min.
// Usa videos.list (1 unidade) em vez de search (100 unidades) — 99% mais barato.
const POST_LIVE_UNTIL_KEY  = "ibk_post_live_until_v1";
const POST_LIVE_RETRY_KEY  = "ibk_post_live_retry_v1";
const LIVE_VIDEO_ID_KEY    = "ibk_live_video_id_v1"; // salvo durante a live para o retry
const POST_LIVE_DURATION_MS  = 10 * 60 * 1000;
const POST_LIVE_INTERVAL_MS  =  3 * 60 * 1000;

const LAST_LIVE_FLAG = "ibk_was_live_v1";

type Janela = { dia: number; inicio: number; fim: number };
const JANELAS_LIVE: Janela[] = [
  { dia: 0, inicio: 8.5, fim: 11 },
  { dia: 0, inicio: 18, fim: 20.5 },
  { dia: 3, inicio: 19, fim: 21.5 },
  { dia: 6, inicio: 17.5, fim: 20 },
];

export function estaEmHorarioDeCulto(): boolean {
  const agora = new Date();
  const dia = agora.getDay();
  const hora = agora.getHours() + agora.getMinutes() / 60;
  return JANELAS_LIVE.some((j) => j.dia === dia && hora >= j.inicio && hora < j.fim);
}

export type LiveCheck = { isLive: boolean; videoId: string | null; ts: number };

function readCache<T extends { ts: number }>(key: string, ttl: number): T | null {
  try {
    const raw = localStorage.getItem(key);
    if (!raw) return null;
    const data = JSON.parse(raw) as T;
    if (Date.now() - data.ts > ttl) return null;
    return data;
  } catch {
    return null;
  }
}

function writeCache(key: string, data: object) {
  try {
    localStorage.setItem(key, JSON.stringify(data));
  } catch {}
}

function clearCache(key: string) {
  try {
    localStorage.removeItem(key);
  } catch {}
}

export function isInPostLiveWindow(): boolean {
  try {
    return Date.now() < Number(localStorage.getItem(POST_LIVE_UNTIL_KEY) ?? "0");
  } catch {
    return false;
  }
}

function trackLiveTransition(isLive: boolean, videoId?: string | null) {
  try {
    const wasLive = localStorage.getItem(LAST_LIVE_FLAG) === "1";
    if (isLive && videoId) {
      // Persiste o videoId da live — o mesmo ID será usado no vídeo gravado
      localStorage.setItem(LIVE_VIDEO_ID_KEY, videoId);
    }
    if (wasLive && !isLive) {
      clearCache(COMPLETED_CACHE_KEY);
      localStorage.setItem(POST_LIVE_UNTIL_KEY, String(Date.now() + POST_LIVE_DURATION_MS));
      localStorage.removeItem(POST_LIVE_RETRY_KEY);
    }
    localStorage.setItem(LAST_LIVE_FLAG, isLive ? "1" : "0");
  } catch {}
}

export async function checkLive(): Promise<LiveCheck> {
  const cached = readCache<LiveCheck>(CACHE_KEY, CACHE_TTL_MS);
  if (cached) return cached;

  if (!API_KEY) {
    trackLiveTransition(false);
    return { isLive: false, videoId: null, ts: Date.now() };
  }

  try {
    const url = `https://www.googleapis.com/youtube/v3/search?part=id&channelId=${CHANNEL_ID}&eventType=live&type=video&key=${API_KEY}`;
    const res = await fetch(url);
    if (!res.ok) throw new Error();
    const data = await res.json();
    const items: Array<{ id?: { videoId?: string } }> = data.items || [];
    const videoId = items[0]?.id?.videoId ?? null;
    const result: LiveCheck = { isLive: videoId !== null, videoId, ts: Date.now() };
    writeCache(CACHE_KEY, result);
    trackLiveTransition(result.isLive, videoId);
    return result;
  } catch {
    trackLiveTransition(false);
    return { isLive: false, videoId: null, ts: Date.now() };
  }
}

// Retorna o videoId do último culto gravado — usado em "Último Culto".
//
// Retry pós-live (8 min, intervalo 90s):
//   Usa videos.list com o liveVideoId salvo = 1 unidade de quota por chamada.
//   O YouTube mantém o mesmo videoId após converter de live para gravado.
//   Fallback para search (100 unidades) apenas se não houver liveVideoId salvo.
export async function getLastCompletedLive(): Promise<string | null> {
  const postLive = isInPostLiveWindow();

  if (!postLive) {
    const cached = readCache<{ videoId: string; ts: number }>(COMPLETED_CACHE_KEY, COMPLETED_TTL_MS);
    if (cached) return cached.videoId;
  } else {
    try {
      const lastRetry = Number(localStorage.getItem(POST_LIVE_RETRY_KEY) ?? "0");
      if (Date.now() - lastRetry < POST_LIVE_INTERVAL_MS) {
        const stale = readCache<{ videoId: string; ts: number }>(COMPLETED_CACHE_KEY, Infinity);
        return stale ? stale.videoId : null;
      }
      localStorage.setItem(POST_LIVE_RETRY_KEY, String(Date.now()));
    } catch {}
  }

  if (!API_KEY) return null;

  // Durante retry pós-live: verificar se o vídeo da live já está pronto para
  // tocar via videos.list (1 unidade) em vez de search (100 unidades).
  // Só declara pronto quando processingStatus=succeeded, embeddable=true e public —
  // o iframe falha em qualquer outro estado.
  if (postLive) {
    try {
      const savedId = localStorage.getItem(LIVE_VIDEO_ID_KEY);
      if (savedId) {
        const url = `https://www.googleapis.com/youtube/v3/videos?part=status,processingDetails&id=${savedId}&key=${API_KEY}`;
        const res = await fetch(url);
        if (res.ok) {
          const data = await res.json();
          const item = (data.items ?? [])[0] as
            | { status?: { privacyStatus?: string; embeddable?: boolean }; processingDetails?: { processingStatus?: string } }
            | undefined;
          const ready =
            item?.processingDetails?.processingStatus === "succeeded" &&
            item?.status?.privacyStatus === "public" &&
            item?.status?.embeddable === true;
          if (ready) {
            writeCache(COMPLETED_CACHE_KEY, { videoId: savedId, ts: Date.now() });
            return savedId;
          }
        }
        // Ainda processando ou não public/embeddable — próxima tentativa
        return null;
      }
    } catch {}
    // Sem liveVideoId salvo: cai no search abaixo (raro — só em sessão nova)
  }

  try {
    const url = `https://www.googleapis.com/youtube/v3/search?part=id&channelId=${CHANNEL_ID}&eventType=completed&type=video&order=date&maxResults=1&key=${API_KEY}`;
    const res = await fetch(url);
    if (!res.ok) return null;
    const data = await res.json();
    const items: Array<{ id?: { videoId?: string } }> = data.items || [];
    const videoId = items[0]?.id?.videoId ?? null;
    if (videoId) writeCache(COMPLETED_CACHE_KEY, { videoId, ts: Date.now() });
    return videoId;
  } catch {
    return null;
  }
}
