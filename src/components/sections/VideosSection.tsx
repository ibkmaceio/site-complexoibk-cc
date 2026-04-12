import Link from "next/link";
import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";
import videosData from "@/lib/data/videos.json";

const PINNED_ID = videosData.pinnedPodcastId;
const ALL = videosData.podcasts;
const principal = ALL.find((v) => v.id === PINNED_ID) ?? ALL[0];
const lateraisAll = ALL.filter((v) => v.id !== principal.id);
const PLAYLIST_URL = "https://www.youtube.com/playlist?list=PLW0VOn2DYtJ5JOiu83F2IJJ6Bnh8Yq87-";

function formatDate(dateStr: string) {
  return new Date(dateStr).toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  });
}

export default function VideosSection() {
  const laterais = lateraisAll;

  return (
    <section className="bg-[#080808] py-28 px-6 sm:px-10 lg:px-16">
      <div className="max-w-7xl mx-auto">

        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16">
          <FadeIn>
            <div>
              <div className="flex items-center gap-3 mb-4">
                <span className="w-6 h-px bg-[#E84C1E]" />
                <span className="text-white/50 text-xs font-body uppercase tracking-[0.2em]">
                  {COPY.tvIbk.eyebrow}
                </span>
              </div>
              <h2 className="font-display font-900 text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight tracking-tight">
                {COPY.tvIbk.headline}
              </h2>
            </div>
          </FadeIn>

          <FadeIn delay={0.1}>
            <a
              href={PLAYLIST_URL}
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-2 text-white/50 hover:text-white font-display font-700 text-sm transition-colors group shrink-0"
            >
              {COPY.tvIbk.cta}
              <ArrowRight size={15} className="group-hover:translate-x-1 transition-transform" />
            </a>
          </FadeIn>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">

          {/* Vídeo principal */}
          <FadeIn className="lg:col-span-7">
            <a
              href={`https://youtube.com/watch?v=${principal.id}`}
              target="_blank"
              rel="noopener noreferrer"
              className="group block"
            >
              <div className="relative aspect-video bg-[#111] rounded overflow-hidden">
                <img
                  src={principal.thumbnail}
                  alt={principal.titulo}
                  className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <div className="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors" />
                {/* Play button */}
                <div className="absolute inset-0 flex items-center justify-center">
                  <div className="w-18 h-18 flex items-center justify-center rounded-full border-2 border-white/80 bg-black/30 backdrop-blur-sm transition-all group-hover:bg-[#E84C1E] group-hover:border-[#E84C1E] group-hover:scale-110">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="white" className="ml-1">
                      <polygon points="5 3 19 12 5 21 5 3" />
                    </svg>
                  </div>
                </div>
              </div>
              <div className="mt-4 px-1">
                <h3 className="font-display font-800 text-lg text-white leading-snug group-hover:text-[#E84C1E] transition-colors">
                  {principal.titulo}
                </h3>
                <p className="text-white/40 font-body text-xs mt-1">
                  {formatDate(principal.data)}
                </p>
              </div>
            </a>
          </FadeIn>

          {/* Laterais */}
          <div className="lg:col-span-5 flex flex-col justify-between gap-5">
            {laterais.slice(0, 4).map((v, i) => (
              <FadeIn key={v.titulo + i} delay={i * 0.08} direction="left">
                <a
                  href={`https://youtube.com/watch?v=${v.id}`}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="group flex gap-4 items-start"
                >
                  <div className="relative w-32 aspect-video bg-[#111] rounded overflow-hidden shrink-0">
                    <img
                      src={v.thumbnail}
                      alt={v.titulo}
                      className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                    <div className="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/0 transition-colors">
                      <div className="w-7 h-7 flex items-center justify-center rounded-full bg-[#E84C1E]/80">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="white" className="ml-0.5">
                          <polygon points="5 3 19 12 5 21 5 3" />
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div className="flex-1 pt-1">
                    <h4 className="font-display font-700 text-sm text-white/80 leading-snug line-clamp-2 group-hover:text-white transition-colors">
                      {v.titulo}
                    </h4>
                    <p className="text-white/35 font-body text-xs mt-1.5">
                      {formatDate(v.data)}
                    </p>
                  </div>
                </a>
              </FadeIn>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
