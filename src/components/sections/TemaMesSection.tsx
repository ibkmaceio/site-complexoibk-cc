"use client";

import Link from "next/link";
import { ArrowRight } from "lucide-react";
import { motion } from "framer-motion";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";

export default function TemaMesSection() {
  const valores = COPY.sobre.valores;

  return (
    <section className="bg-[#0a0a0a] py-28 px-6 sm:px-10 lg:px-16 border-t border-white/5">
      <div className="max-w-7xl mx-auto">

        {/* Eyebrow */}
        <FadeIn>
          <div className="flex items-center gap-3 mb-4">
            <span className="w-6 h-px bg-[#E84C1E]" />
            <span className="text-white/50 text-xs font-body uppercase tracking-[0.2em]">
              {COPY.sobre.eyebrow}
            </span>
          </div>
        </FadeIn>

        {/* Headline + link */}
        <FadeIn delay={0.08}>
          <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-16">
            <h2 className="font-display font-900 text-[clamp(2.2rem,4vw,3.2rem)] text-white leading-tight tracking-tight max-w-xl">
              Quem somos e<br />
              <span className="font-serif italic font-700 text-white/80">para onde vamos.</span>
            </h2>
            <Link
              href="/sobre"
              className="inline-flex items-center gap-2 text-white/50 font-display font-700 text-sm hover:text-[#E84C1E] transition-colors group shrink-0"
            >
              {COPY.sobre.cta}
              <ArrowRight size={14} className="group-hover:translate-x-1 transition-transform" />
            </Link>
          </div>
        </FadeIn>

        {/* Missão + Visão */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          {[COPY.sobre.missao, COPY.sobre.visao].map((item, i) => (
            <FadeIn key={item.titulo} delay={0.1 + i * 0.08}>
              <motion.div
                whileHover={{ scale: 1.02, y: -3 }}
                transition={{ duration: 0.25, ease: [0.16, 1, 0.3, 1] }}
                className="group relative overflow-hidden border border-white/8 rounded p-8 bg-[#111] hover:border-[#E84C1E]/40 hover:bg-[#130a09] transition-colors duration-300"
              >
                <div className="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#E84C1E] to-transparent opacity-0 group-hover:opacity-100 transition-opacity" />
                <span className="font-display font-800 text-[10px] uppercase tracking-[0.25em] text-white/30 block mb-4">
                  {item.titulo}
                </span>
                <p className="font-display font-800 text-[clamp(1.1rem,2vw,1.4rem)] text-white leading-snug">
                  {item.texto}
                </p>
              </motion.div>
            </FadeIn>
          ))}
        </div>

        {/* Valores */}
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
          {valores.map((v, i) => (
            <FadeIn key={v.titulo} delay={0.2 + i * 0.06}>
              <motion.div
                whileHover={{ scale: 1.03, y: -4 }}
                transition={{ duration: 0.25, ease: [0.16, 1, 0.3, 1] }}
                className="group relative overflow-hidden border border-white/8 rounded p-5 bg-[#111] hover:border-[#E84C1E]/40 hover:bg-[#130a09] transition-colors duration-300"
              >
                <div className="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#E84C1E] to-transparent opacity-0 group-hover:opacity-100 transition-opacity" />
                <span className="text-[#E84C1E] text-xl block mb-3">{v.icone}</span>
                <h4 className="font-display font-800 text-white text-sm uppercase tracking-widest mb-2 group-hover:text-[#E84C1E] transition-colors">
                  {v.titulo}
                </h4>
                <p className="text-white/45 font-body text-xs leading-relaxed">{v.texto}</p>
              </motion.div>
            </FadeIn>
          ))}
        </div>

      </div>
    </section>
  );
}
