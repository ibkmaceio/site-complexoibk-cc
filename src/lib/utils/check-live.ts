// Detecção de transmissão ao vivo do canal IBK Maceió no YouTube.
// Compartilhado entre HeroSection (CTA destacado) e AoVivoPlayer (player principal).

const CHANNEL_ID = "UCRdiHrr_rVcJoxfv62QAYTw";
const API_KEY = process.env.NEXT_PUBLIC_YOUTUBE_API_KEY;
const CACHE_KEY = "ibk_live_check_v1";
const CACHE_TTL_MS = 5 * 60 * 1000;

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

function readCache(): LiveCheck | null {
  try {
    const raw = localStorage.getItem(CACHE_KEY);
    if (!raw) return null;
    const data = JSON.parse(raw) as LiveCheck;
    if (Date.now() - data.ts > CACHE_TTL_MS) return null;
    return data;
  } catch {
    return null;
  }
}

function writeCache(data: LiveCheck) {
  try {
    localStorage.setItem(CACHE_KEY, JSON.stringify(data));
  } catch {}
}

export async function checkLive(): Promise<LiveCheck> {
  const cached = readCache();
  if (cached) return cached;

  if (!API_KEY) {
    return { isLive: estaEmHorarioDeCulto(), videoId: null, ts: Date.now() };
  }

  try {
    const url = `https://www.googleapis.com/youtube/v3/search?part=id&channelId=${CHANNEL_ID}&eventType=live&type=video&key=${API_KEY}`;
    const res = await fetch(url);
    if (!res.ok) throw new Error("YouTube API error");
    const data = await res.json();
    const items: Array<{ id?: { videoId?: string } }> = data.items || [];
    const result: LiveCheck = {
      isLive: items.length > 0,
      videoId: items[0]?.id?.videoId ?? null,
      ts: Date.now(),
    };
    writeCache(result);
    return result;
  } catch {
    return { isLive: estaEmHorarioDeCulto(), videoId: null, ts: Date.now() };
  }
}
