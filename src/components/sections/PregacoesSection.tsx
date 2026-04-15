import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";
import videosData from "@/lib/data/videos.json";

const VIDEOS = videosData.pedro;
const CANAL_URL = "https://www.youtube.com/channel/UC2_fs68CsAsM3eh9WoWByPQ";

function formatDate(dateStr: string) {
  return new Date(dateStr).toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  });
}

export default function PregacoesSection() {
  return (
    <section className="bg-ibk-dark-surface py-16 sm:py-20 lg:py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10">
      <div className="max-w-7xl mx-auto">

        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16">
          <FadeIn>
            <div>
              <div className="flex items-center gap-3 mb-4">
                <span className="w-6 h-px bg-[#E84C1E]" />
                <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                  {COPY.pregacoes.eyebrow}
                </span>
              </div>
              <h2 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight tracking-tight">
                {COPY.pregacoes.headline}
              </h2>
              <p className="text-white/65 font-body text-sm mt-2">
                {COPY.pregacoes.subline}{" "}
                <span className="font-serif italic text-white/65">ouça agora.</span>
              </p>
            </div>
          </FadeIn>

          <FadeIn delay={0.1}>
            <a
              href={CANAL_URL}
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-2 text-white/65 hover:text-white active:text-white font-display font-bold text-sm transition-colors group shrink-0"
            >
              {COPY.pregacoes.cta}
              <ArrowRight size={15} className="group-hover:translate-x-1 group-active:translate-x-1 transition-transform" />
            </a>
          </FadeIn>
        </div>

        {/* Grid 2x2 */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          {VIDEOS.slice(0, 4).map((v, i) => (
            <FadeIn key={v.id} delay={i * 0.07}>
              <a
                href={`https://youtube.com/watch?v=${v.id}`}
                target="_blank"
                rel="noopener noreferrer"
                className="group block"
              >
                <div className="relative aspect-video bg-ibk-dark-surface rounded overflow-hidden mb-3">
                  <img
                    src={v.thumbnail}
                    alt={v.titulo}
                    loading="lazy"
                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 group-active:scale-105"
                  />
                  <div className="absolute inset-0 bg-black/15 group-hover:bg-black/0 group-active:bg-black/0 transition-colors" />
                  <div className="absolute inset-0 flex items-center justify-center">
                    <div className="w-9 h-9 flex items-center justify-center rounded-full bg-[#E84C1E]/90 group-hover:bg-[#E84C1E] group-hover:scale-110 group-active:bg-[#E84C1E] group-active:scale-110 transition-all">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="white" className="ml-0.5">
                        <polygon points="5 3 19 12 5 21 5 3" />
                      </svg>
                    </div>
                  </div>
                </div>
                <h4 className="font-display font-bold text-sm text-white/90 leading-snug line-clamp-2 group-hover:text-white group-active:text-white transition-colors">
                  {v.titulo}
                </h4>
                <p className="text-white/65 font-body text-xs mt-1">
                  {formatDate(v.data)}
                </p>
              </a>
            </FadeIn>
          ))}
        </div>
      </div>
    </section>
  );
}
