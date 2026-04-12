/**
 * Busca os últimos vídeos dos dois canais do YouTube via RSS público.
 * Roda antes do build: não precisa de API key.
 * Se a rede falhar, mantém o videos.json existente.
 */

import { writeFileSync, existsSync, readFileSync } from "fs";
import { join, dirname } from "path";
import { fileURLToPath } from "url";

const __dirname = dirname(fileURLToPath(import.meta.url));
const OUTPUT = join(__dirname, "../src/lib/data/videos.json");

const CHANNELS = {
  ibk: "UCRdiHrr_rVcJoxfv62QAYTw",
  pedro: "UC2_fs68CsAsM3eh9WoWByPQ",
};

const PLAYLISTS = {
  podcasts: "PLW0VOn2DYtJ5JOiu83F2IJJ6Bnh8Yq87-",
};

function decode(str) {
  return str
    .replace(/&amp;/g, "&")
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'");
}

function parseRSS(xml) {
  const entries = [];
  const re = /<entry>([\s\S]*?)<\/entry>/g;
  let m;
  while ((m = re.exec(xml)) !== null) {
    const e = m[1];
    const id = (e.match(/<yt:videoId>([^<]+)<\/yt:videoId>/) || [])[1];
    const title = (e.match(/<title>([^<]+)<\/title>/) || [])[1];
    const published = (e.match(/<published>([^<]+)<\/published>/) || [])[1];
    if (id && title && published) {
      entries.push({
        id,
        titulo: decode(title),
        data: published.split("T")[0],
        thumbnail: `https://i.ytimg.com/vi/${id}/hqdefault.jpg`,
      });
    }
  }
  return entries;
}

async function fetchFeed(url) {
  const res = await fetch(url, { signal: AbortSignal.timeout(8000) });
  if (!res.ok) throw new Error(`HTTP ${res.status}`);
  return parseRSS(await res.text());
}

function channelUrl(id) {
  return `https://www.youtube.com/feeds/videos.xml?channel_id=${id}`;
}

function playlistUrl(id) {
  return `https://www.youtube.com/feeds/videos.xml?playlist_id=${id}`;
}

try {
  console.log("Buscando videos do YouTube...");
  const [ibk, pedro, podcasts] = await Promise.all([
    fetchFeed(channelUrl(CHANNELS.ibk)),
    fetchFeed(channelUrl(CHANNELS.pedro)),
    fetchFeed(playlistUrl(PLAYLISTS.podcasts)),
  ]);

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

  writeFileSync(OUTPUT, JSON.stringify(data, null, 2));
  console.log(`TV IBK: ${data.ibk.length} | Pedro Luz: ${data.pedro.length} | Podcasts: ${data.podcasts.length}`);
} catch (err) {
  if (existsSync(OUTPUT)) {
    console.warn(`Sem rede - usando videos.json existente. (${err.message})`);
  } else {
    console.error("Falha ao buscar videos e videos.json nao existe:", err.message);
    process.exit(1);
  }
}
