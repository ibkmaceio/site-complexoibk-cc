"use client";

import Link from "next/link";
import { ArrowRight } from "lucide-react";
import { motion } from "framer-motion";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";
import { PROGRAMACAO } from "@/lib/data/mock";

export default function ProgramacaoSection() {
  return (
    <section className="bg-ibk-dark-surface py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10">
      <div className="max-w-7xl mx-auto">

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">

          {/* Header */}
          <div className="lg:col-span-1">
            <FadeIn>
              <div className="flex items-center gap-3 mb-6">
                <span className="w-6 h-px bg-[#E84C1E]" />
                <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                  {COPY.programacao.eyebrow}
                </span>
              </div>
              <h2 className="font-display font-black text-[clamp(2.5rem,4vw,3.5rem)] text-white leading-tight tracking-tight mb-4">
                {COPY.programacao.headline}
              </h2>
              <p className="text-white/65 font-body text-sm leading-relaxed mb-8">
                {COPY.programacao.subline}
              </p>
              <Link
                href="/programacao"
                className="inline-flex items-center gap-2 text-white font-display font-bold text-sm hover:text-[#E84C1E] transition-colors group"
              >
                {COPY.programacao.cta}
                <ArrowRight size={15} className="group-hover:translate-x-1 transition-transform" />
              </Link>
            </FadeIn>
          </div>

          {/* Cards */}
          <div className="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            {PROGRAMACAO.flatMap((dia) =>
              dia.cultos.map((culto, i) => (
                <FadeIn key={`${dia.dia}-${i}`} delay={i * 0.08}>
                  <motion.div
                    whileHover={{ scale: 1.03, y: -4 }}
                    transition={{ duration: 0.25, ease: [0.16, 1, 0.3, 1] }}
                    className="group relative overflow-hidden border border-white/10 rounded p-6 bg-ibk-dark-card hover:border-[#E84C1E]/50 hover:bg-[#2e1a0e] transition-colors duration-300"
                  >
                    <div className="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#E84C1E] to-transparent opacity-0 group-hover:opacity-100 transition-opacity" />

                    <span className="font-display font-extrabold text-[10px] uppercase tracking-[0.25em] text-white/65 block mb-4">
                      {dia.dia}
                    </span>
                    <h3 className="font-display font-extrabold text-xl text-white mb-3 group-hover:text-[#E84C1E] transition-colors">
                      {culto.nome}
                    </h3>
                    <p className="font-display font-bold text-3xl text-white/40">
                      {culto.horario}
                    </p>
                  </motion.div>
                </FadeIn>
              ))
            )}
          </div>
        </div>
      </div>
    </section>
  );
}
