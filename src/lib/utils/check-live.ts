// Detecção de transmissão ao vivo do canal IBK Maceió no YouTube.
// Compartilhado entre HeroSection (CTA destacado) e AoVivoPlayer (player principal).

const CHANNEL_ID = "UCRdiHrr_rVcJoxfv62QAYTw";
const API_KEY = process.env.NEXT_PUBLIC_YOUTUBE_API_KEY;
const CACHE_KEY = "ibk_live_check_v1";
const CACHE_TTL_MS = 2 * 60 * 1000;

const COMPLETED_CACHE_KEY = "ibk_last_completed_v1";
const COMPLETED_TTL_MS = 3 * 60 * 1000;

// Janela de retry pós-live: por 15 min após encerrar, ignora cache e re-tenta
// a cada 1 min — até o YouTube processar e disponibilizar o vídeo gravado.
const POST_LIVE_UNTIL_KEY = "ibk_post_live_until_v1";
const POST_LIVE_RETRY_KEY  = "ibk_post_live_retry_v1";
const POST_LIVE_DURATION_MS = 15 * 60 * 1000;
const POST_LIVE_INTERVAL_MS =  1 * 60 * 1000;

const LAST_LIVE_FLAG = "ibk_was_live_v1";

// Janelas de fallback se a API falhar — fuso do navegador, cobre o público local.
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

// Retorna se estamos dentro da janela de retry pós-live (15 min após encerrar).
export function isInPostLiveWindow(): boolean {
  try {
    const until = Number(localStorage.getItem(POST_LIVE_UNTIL_KEY) ?? "0");
    return Date.now() < until;
  } catch {
    return false;
  }
}

// Detecta transição live→offline e abre janela de retry de 15 min.
function trackLiveTransition(isLive: boolean) {
  try {
    const wasLive = localStorage.getItem(LAST_LIVE_FLAG) === "1";
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
    const result: LiveCheck = { isLive: false, videoId: null, ts: Date.now() };
    trackLiveTransition(false);
    return result;
  }

  try {
    const url = `https://www.googleapis.com/youtube/v3/search?part=id&channelId=${CHANNEL_ID}&eventType=live&type=video&key=${API_KEY}`;
    const res = await fetch(url);
    if (!res.ok) throw new Error("YouTube API error");
    const data = await res.json();
    const items: Array<{ id?: { videoId?: string } }> = data.items || [];
    const videoId = items[0]?.id?.videoId ?? null;
    const result: LiveCheck = {
      isLive: videoId !== null,
      videoId,
      ts: Date.now(),
    };
    writeCache(CACHE_KEY, result);
    trackLiveTransition(result.isLive);
    return result;
  } catch {
    const result: LiveCheck = { isLive: false, videoId: null, ts: Date.now() };
    trackLiveTransition(false);
    return result;
  }
}

// Retorna o videoId da live mais recente já encerrada — usado em "Último Culto".
//
// Comportamento pós-live (até 15 min após encerrar):
//   - Ignora cache de 3 min e re-tenta a cada 1 min até o YouTube processar.
//   - Assim que o vídeo aparecer, salva no cache e para de re-tentar.
//
// Fora da janela pós-live: cache normal de 3 min.
export async function getLastCompletedLive(): Promise<string | null> {
  const postLive = isInPostLiveWindow();

  if (!postLive) {
    const cached = readCache<{ videoId: string; ts: number }>(COMPLETED_CACHE_KEY, COMPLETED_TTL_MS);
    if (cached) return cached.videoId;
  } else {
    // Dentro da janela pós-live: rate-limit a 1 chamada por minuto
    try {
      const lastRetry = Number(localStorage.getItem(POST_LIVE_RETRY_KEY) ?? "0");
      if (Date.now() - lastRetry < POST_LIVE_INTERVAL_MS) {
        // Ainda não é hora de re-tentar — retorna cache atual (mesmo que expirado)
        const stale = readCache<{ videoId: string; ts: number }>(COMPLETED_CACHE_KEY, Infinity);
        return stale ? stale.videoId : null;
      }
      localStorage.setItem(POST_LIVE_RETRY_KEY, String(Date.now()));
    } catch {}
  }

  if (!API_KEY) return null;

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
