"use client";

import { useState, useEffect } from "react";
import { CHURCH_INFO, PROGRAMACAO } from "@/lib/data/mock";
import videosData from "@/lib/data/videos.json";
import { checkLive } from "@/lib/utils/check-live";

const CHANNEL_ID = "UCRdiHrr_rVcJoxfv62QAYTw";
const ultimoCulto = videosData.ibk[1] ?? videosData.ibk[0];

export default function AoVivoPlayer() {
  // Default false para SSR (evita hydration mismatch).
  const [live, setLive] = useState(false);
  const [liveVideoId, setLiveVideoId] = useState<string | null>(null);

  useEffect(() => {
    checkLive().then((result) => {
      if (result.isLive) {
        setLive(true);
        setLiveVideoId(result.videoId);
      }
    });
  }, []);

  const src = live
    ? liveVideoId
      ? `https://www.youtube-nocookie.com/embed/${liveVideoId}?autoplay=1&rel=0`
      : `https://www.youtube-nocookie.com/embed/live_stream?channel=${CHANNEL_ID}&autoplay=1&rel=0`
    : `https://www.youtube-nocookie.com/embed/${ultimoCulto.id}?rel=0`;

  return (
    <section className="px-6 sm:px-10 lg:px-16 py-16 max-w-7xl mx-auto">

      {/* Header */}
      <div className="flex items-center justify-between mb-8">
        <div>
          <div className="flex items-center gap-3 mb-3">
            <span className="w-6 h-px bg-[#E84C1E]" />
            <span className="text-white/50 text-xs font-body uppercase tracking-[0.2em]">
              Transmissão
            </span>
          </div>
          <h1 className="font-display font-900 text-[clamp(2rem,4vw,3rem)] text-white leading-tight">
            Ao Vivo
          </h1>
        </div>

        {/* Abas */}
        <div className="flex gap-2">
          <button
            onClick={() => setLive(true)}
            className={`flex items-center gap-2 px-4 py-2.5 rounded text-sm font-display font-700 transition-all ${
              live
                ? "bg-[#E84C1E] text-white"
                : "bg-white/8 text-white/50 hover:text-white hover:bg-white/12"
            }`}
          >
            <span className={`w-2 h-2 rounded-full shrink-0 ${live ? "bg-white animate-pulse" : "bg-white/30"}`} />
            Ao Vivo
          </button>
          <button
            onClick={() => setLive(false)}
            className={`px-4 py-2.5 rounded text-sm font-display font-700 transition-all ${
              !live
                ? "bg-white/15 text-white"
                : "bg-white/8 text-white/50 hover:text-white hover:bg-white/12"
            }`}
          >
            Último Culto
          </button>
        </div>
      </div>

      {/* Player — tamanho máximo */}
      <div className="w-full aspect-video bg-[#111] rounded overflow-hidden">
        <iframe
          key={src}
          src={src}
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowFullScreen
          className="w-full h-full"
          title="IBK Maceió"
        />
      </div>

      {/* Info abaixo do player */}
      <div className="mt-3 flex items-center justify-between gap-4">
        {live ? (
          <p className="text-white/30 font-body text-xs">
            Sem transmissão ativa?{" "}
            <button onClick={() => setLive(false)} className="text-[#E84C1E] hover:underline">
              Ver último culto
            </button>
          </p>
        ) : (
          <p className="text-white/30 font-body text-xs truncate">{ultimoCulto.titulo}</p>
        )}
        <a
          href={CHURCH_INFO.youtube}
          target="_blank"
          rel="noopener noreferrer"
          className="text-white/30 hover:text-white font-body text-xs transition-colors shrink-0"
        >
          Abrir no YouTube →
        </a>
      </div>

      {/* Programação */}
      <div className="mt-14">
        <h2 className="font-display font-800 text-xs uppercase tracking-widest text-white/40 mb-5">
          Programação dos Cultos
        </h2>
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
          {PROGRAMACAO.flatMap((dia) =>
            dia.cultos.map((culto, i) => (
              <div
                key={`${dia.dia}-${i}`}
                className="p-5 border border-white/8 rounded bg-[#111]"
              >
                <span className="font-display font-800 text-[10px] uppercase tracking-widest text-white/30 block mb-2">
                  {dia.dia}
                </span>
                <span className="font-display font-700 text-white text-sm block mb-1">
                  {culto.nome}
                </span>
                <span className="font-display font-900 text-3xl text-white/15 block">
                  {culto.horario}
                </span>
              </div>
            ))
          )}
        </div>
      </div>
    </section>
  );
}
