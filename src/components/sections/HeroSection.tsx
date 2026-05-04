import Link from "next/link";
import HeroVideo from "./HeroVideo";
import HeroLiveCta from "./HeroLiveCta";
import { COPY } from "@/lib/data/copy";
import { CHURCH_INFO } from "@/lib/data/mock";

export default function HeroSection() {
  return (
    <section
      className="relative min-h-screen flex flex-col justify-end overflow-hidden bg-ibk-dark-deep"
      style={{ minHeight: "100svh" }}
    >

      {/* Vídeo de fundo — carregado de forma diferida (não bloqueia LCP) */}
      <HeroVideo />

      {/* Gradientes */}
      <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent" />
      <div className="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent" />

      {/* Conteúdo — renderizado pelo servidor, sem esperar JS */}
      <div className="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-16 pt-20 sm:pb-20 sm:pt-28 lg:pb-20 lg:pt-32">
        <div className="max-w-3xl">

          {/* Eyebrow */}
          <div className="flex items-center gap-3 mb-5 sm:mb-8 animate-hero-fade" style={{ animationDelay: "0.1s" }}>
            <span className="w-6 h-px bg-[#E84C1E]" />
            <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
              {COPY.hero.eyebrow}
            </span>
          </div>

          {/* Headline — LCP element: sem delay, sem hidden, renderiza imediatamente */}
          <h1 className="font-display font-black text-[clamp(2.2rem,8vw,7.5rem)] text-white leading-[0.9] tracking-tight mb-5 sm:mb-8">
            Você foi feito
            <br />
            para{" "}
            <span className="font-serif italic text-white/90">pertencer.</span>
          </h1>

          {/* Subline */}
          <p
            className="text-white/60 font-body text-base sm:text-lg max-w-xl leading-relaxed mb-8 sm:mb-12 animate-hero-fade"
            style={{ animationDelay: "0.5s" }}
          >
            {COPY.hero.subline}
          </p>

          {/* CTAs */}
          <div
            className="flex flex-wrap gap-4 animate-hero-fade"
            style={{ animationDelay: "0.7s" }}
          >
            <Link
              href="/programacao"
              className="group px-8 py-4 bg-white text-[#0d0d0d] font-display font-extrabold text-sm tracking-wide rounded hover:bg-[#F8F6F5] active:bg-[#F8F6F5] transition-all"
            >
              {COPY.hero.cta1}
            </Link>
            <HeroLiveCta defaultLabel={COPY.hero.cta2} />
          </div>
        </div>
      </div>

      {/* Redes sociais lateral */}
      <div
        className="absolute right-8 bottom-20 z-10 hidden lg:flex flex-col items-center gap-4 animate-hero-fade"
        style={{ animationDelay: "1s" }}
      >
        <a
          href={CHURCH_INFO.instagram}
          target="_blank"
          rel="noopener noreferrer"
          className="text-white/40 hover:text-[#E84C1E] active:text-[#E84C1E] transition-colors"
          aria-label="Instagram"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
            <rect x="2" y="2" width="20" height="20" rx="5"/>
            <circle cx="12" cy="12" r="4"/>
            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
          </svg>
        </a>
        <a
          href={CHURCH_INFO.youtube}
          target="_blank"
          rel="noopener noreferrer"
          className="text-white/40 hover:text-[#E84C1E] active:text-[#E84C1E] transition-colors"
          aria-label="YouTube"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/>
            <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/>
          </svg>
        </a>
        <div className="w-px h-16 bg-white/20" />
      </div>

      {/* Scroll indicator */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 animate-hero-fade" style={{ animationDelay: "1.2s" }}>
        <div className="w-px h-12 bg-gradient-to-b from-white/40 to-transparent animate-scroll-bounce" />
      </div>
    </section>
  );
}
