"use client";

import { motion } from "framer-motion";
import Link from "next/link";
import { COPY } from "@/lib/data/copy";
import { CHURCH_INFO } from "@/lib/data/mock";

export default function HeroSection() {
  return (
    <section className="relative min-h-screen flex flex-col justify-end overflow-hidden bg-ibk-dark-deep">

      {/* ── Vídeo de fundo YouTube ── */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        <iframe
          src="https://www.youtube.com/embed/mvILffB2f5A?autoplay=1&mute=1&loop=1&playlist=mvILffB2f5A&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&disablekb=1&iv_load_policy=3"
          allow="autoplay; encrypted-media"
          style={{
            position: "absolute",
            top: "50%",
            left: "50%",
            width: "100vw",
            height: "56.25vw",
            minHeight: "100%",
            minWidth: "177.78vh",
            transform: "translate(-50%, -50%)",
            border: 0,
          }}
          title="IBK — Vídeo Hero"
        />
      </div>

      {/* ── Gradientes cinematográficos ── */}
      <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent" />
      <div className="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent" />

      {/* ── Conteúdo ── */}
      <div className="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-20 pt-32">
        <div className="max-w-3xl">

          {/* Eyebrow */}
          <motion.div
            initial={{ opacity: 0, y: 20, filter: "blur(8px)" }}
            animate={{ opacity: 1, y: 0, filter: "blur(0px)" }}
            transition={{ duration: 0.8, delay: 0.2, ease: [0.16, 1, 0.3, 1] }}
            className="flex items-center gap-3 mb-8"
          >
            <span className="w-6 h-px bg-[#E84C1E]" />
            <span className="text-white/60 text-xs font-body uppercase tracking-[0.2em]">
              {COPY.hero.eyebrow}
            </span>
          </motion.div>

          {/* Headline */}
          <div className="overflow-hidden mb-8">
            <motion.h1
              initial={{ y: "100%" }}
              animate={{ y: 0 }}
              transition={{ duration: 0.9, delay: 0.3, ease: [0.16, 1, 0.3, 1] }}
              className="font-display font-black text-[clamp(3.5rem,9vw,7.5rem)] text-white leading-[0.9] tracking-tight"
            >
              Você foi feito
              <br />
              para{" "}
              <span className="font-serif italic text-white/90">pertencer.</span>
            </motion.h1>
          </div>

          {/* Subline */}
          <motion.p
            initial={{ opacity: 0, filter: "blur(6px)" }}
            animate={{ opacity: 1, filter: "blur(0px)" }}
            transition={{ duration: 0.9, delay: 0.7, ease: [0.16, 1, 0.3, 1] }}
            className="text-white/60 font-body text-lg max-w-xl leading-relaxed mb-12"
          >
            {COPY.hero.subline}
          </motion.p>

          {/* CTAs */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 0.9 }}
            className="flex flex-wrap gap-4"
          >
            <Link
              href="/programacao"
              className="group px-8 py-4 bg-white text-[#0d0d0d] font-display font-extrabold text-sm tracking-wide rounded hover:bg-[#F8F6F5] transition-all"
            >
              {COPY.hero.cta1}
            </Link>
            <Link
              href="/ao-vivo"
              className="flex items-center gap-3 px-8 py-4 border border-white/25 text-white font-display font-bold text-sm tracking-wide rounded hover:border-[#E84C1E] hover:text-white transition-all"
            >
              <span className="w-2 h-2 rounded-full bg-[#E84C1E] animate-pulse" />
              {COPY.hero.cta2}
            </Link>
          </motion.div>
        </div>
      </div>

      {/* ── Redes sociais lateral ── */}
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ delay: 1.2, duration: 0.8 }}
        className="absolute right-8 bottom-20 z-10 hidden lg:flex flex-col items-center gap-4"
      >
        <a
          href={CHURCH_INFO.instagram}
          target="_blank"
          rel="noopener noreferrer"
          className="text-white/40 hover:text-[#E84C1E] transition-colors"
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
          className="text-white/40 hover:text-[#E84C1E] transition-colors"
          aria-label="YouTube"
        >
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/>
            <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/>
          </svg>
        </a>
        <div className="w-px h-16 bg-white/20" />
      </motion.div>

      {/* ── Scroll indicator ── */}
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ delay: 1.4 }}
        className="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2"
      >
        <motion.div
          animate={{ y: [0, 8, 0] }}
          transition={{ repeat: Infinity, duration: 1.5, ease: "easeInOut" }}
          className="w-px h-12 bg-gradient-to-b from-white/40 to-transparent"
        />
      </motion.div>
    </section>
  );
}
