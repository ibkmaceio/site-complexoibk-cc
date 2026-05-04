"use client";

import { useState, useEffect, useRef } from "react";
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
  const modalRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (openVideo) {
      document.body.style.overflow = "hidden";
      // Foca o container do modal para suporte a leitores de tela
      setTimeout(() => modalRef.current?.focus(), 50);
    } else {
      document.body.style.overflow = "";
    }
    return () => {
      document.body.style.overflow = "";
    };
  }, [openVideo]);

  useEffect(() => {
    const handler = (e: KeyboardEvent) => {
      if (e.key === "Escape") setOpenVideo(null);

      // Focus trap dentro do modal
      if (e.key === "Tab" && openVideo && modalRef.current) {
        const focusable = modalRef.current.querySelectorAll<HTMLElement>(
          'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (e.shiftKey) {
          if (document.activeElement === first) {
            e.preventDefault();
            last?.focus();
          }
        } else {
          if (document.activeElement === last) {
            e.preventDefault();
            first?.focus();
          }
        }
      }
    };
    document.addEventListener("keydown", handler);
    return () => document.removeEventListener("keydown", handler);
  }, [openVideo]);

  return (
    <>
      <section className="bg-ibk-dark-surface py-16 sm:py-20 lg:py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10">
        <div className="max-w-7xl mx-auto">

          {/* Header */}
          <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16">
            <FadeIn>
              <div>
                <div className="flex items-center gap-3 mb-4">
                  <span className="w-6 h-px bg-[#D4521A]" />
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
                className="flex items-center gap-2 text-white/65 hover:text-white active:text-white font-display font-bold text-sm transition-colors group shrink-0"
              >
                {COPY.tvIbk.cta}
                <ArrowRight size={15} className="group-hover:translate-x-1 group-active:translate-x-1 transition-transform" />
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
                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 group-active:scale-105"
                  />
                  <div className="absolute inset-0 bg-black/15 group-hover:bg-black/0 group-active:bg-black/0 transition-colors" />
                  {/* Play button */}
                  <div className="absolute inset-0 flex items-center justify-center">
                    <div className="w-18 h-18 flex items-center justify-center rounded-full border-2 border-white/80 bg-black/25 backdrop-blur-sm transition-all group-hover:bg-[#D4521A] group-hover:border-[#D4521A] group-hover:scale-110 group-active:bg-[#D4521A] group-active:border-[#D4521A] group-active:scale-110">
                      <svg width="28" height="28" viewBox="0 0 24 24" fill="white" className="ml-1">
                        <polygon points="5 3 19 12 5 21 5 3" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div className="mt-4 px-1">
                  <h3 className="font-display font-extrabold text-lg text-white leading-snug group-hover:text-[#D4521A] group-active:text-[#D4521A] transition-colors">
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
                    <div className="relative w-32 shrink-0 aspect-video bg-ibk-dark-card rounded overflow-hidden">
                      <img
                        src={v.thumbnail}
                        alt={v.titulo}
                        loading="lazy"
                        className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 group-active:scale-110"
                      />
                      <div className="absolute inset-0 flex items-center justify-center bg-black/10 group-hover:bg-black/0 group-active:bg-black/0 transition-colors">
                        <div className="w-7 h-7 flex items-center justify-center rounded-full bg-[#D4521A]/90">
                          <svg width="10" height="10" viewBox="0 0 24 24" fill="white" className="ml-0.5">
                            <polygon points="5 3 19 12 5 21 5 3" />
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div className="flex-1 min-w-0 pt-1">
                      <h4 className="font-display font-bold text-sm text-white/90 leading-snug line-clamp-2 group-hover:text-white group-active:text-white transition-colors">
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
            ref={modalRef}
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-video-title"
            tabIndex={-1}
            className="relative w-full max-w-4xl focus:outline-none"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="relative w-full aspect-video">
              <button
                type="button"
                className="absolute top-2 right-2 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-black/60 text-white/80 hover:text-white hover:bg-[#D4521A] active:bg-[#D4521A] transition-colors"
                onClick={() => setOpenVideo(null)}
                aria-label="Fechar"
              >
                <X size={18} />
              </button>
              <iframe
                src={`https://www.youtube-nocookie.com/embed/${openVideo.id}?autoplay=1`}
                allow="autoplay; fullscreen; picture-in-picture"
                allowFullScreen
                className="w-full h-full rounded"
                title={openVideo.titulo}
              />
            </div>
            <div className="mt-3 px-1">
              <h3
                id="modal-video-title"
                className="font-display font-bold text-white text-base leading-snug"
              >
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
