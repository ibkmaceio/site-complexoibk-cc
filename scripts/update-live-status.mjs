/**
 * Atualiza live-status.json com estado atual da live IBK Maceió.
 * Rodado pelo GitHub Actions a cada 5 min — serve como cache centralizado
 * para o site não precisar bater na YouTube API por usuário.
 *
 * Uso:
 *   YOUTUBE_API_KEY=xxx node scripts/update-live-status.mjs <output-path>
 */

import { writeFileSync, existsSync, readFileSync } from "fs";

const CHANNEL_ID = "UCRdiHrr_rVcJoxfv62QAYTw";
const UPLOADS_PLAYLIST_ID = "UU" + CHANNEL_ID.slice(2);
const API_KEY = process.env.YOUTUBE_API_KEY;
const OUTPUT = process.argv[2] || "live-status.json";

if (!API_KEY) {
  console.error("YOUTUBE_API_KEY env var not set");
  process.exit(1);
}

// API key tem restrição HTTP referrer = ibkmaceio.com.br — passamos manualmente
// para a API aceitar requests do GitHub Actions.
const REFERER_HEADER = { Referer: "https://ibkmaceio.com.br/" };

async function fetchLiveStatus() {
  // Passo 1: pegar 5 últimos uploads (1 unidade)
  const playlistUrl = `https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId=${UPLOADS_PLAYLIST_ID}&maxResults=5&key=${API_KEY}`;
  const playlistRes = await fetch(playlistUrl, { headers: REFERER_HEADER });
  if (!playlistRes.ok) throw new Error(`playlistItems HTTP ${playlistRes.status}`);
  const playlistData = await playlistRes.json();
  const ids = (playlistData.items ?? [])
    .map((it) => it.contentDetails?.videoId)
    .filter(Boolean);

  if (ids.length === 0) return { isLive: false, videoId: null };

  // Passo 2: batch check liveStreamingDetails (1 unidade)
  const videosUrl = `https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id=${ids.join(",")}&key=${API_KEY}`;
  const videosRes = await fetch(videosUrl, { headers: REFERER_HEADER });
  if (!videosRes.ok) throw new Error(`videos HTTP ${videosRes.status}`);
  const videosData = await videosRes.json();

  const liveItem = (videosData.items ?? []).find(
    (v) =>
      v.liveStreamingDetails?.actualStartTime &&
      !v.liveStreamingDetails?.actualEndTime,
  );

  return {
    isLive: !!liveItem,
    videoId: liveItem?.id ?? null,
  };
}

try {
  const status = await fetchLiveStatus();
  const next = { ...status, ts: Date.now() };

  // Detecta mudança real (ignora ts) — evita commits desnecessários
  let changed = true;
  if (existsSync(OUTPUT)) {
    try {
      const prev = JSON.parse(readFileSync(OUTPUT, "utf-8"));
      changed = prev.isLive !== next.isLive || prev.videoId !== next.videoId;
    } catch {}
  }

  writeFileSync(OUTPUT, JSON.stringify(next, null, 2) + "\n");
  console.log(`isLive=${next.isLive} videoId=${next.videoId ?? "—"} changed=${changed}`);

  // Sai com código 0 se mudou (workflow vai commitar) ou 78 se não (skip commit)
  process.exit(changed ? 0 : 78);
} catch (err) {
  console.error("Falha:", err.message);
  process.exit(1);
}
