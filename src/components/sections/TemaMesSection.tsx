"use client";

import Link from "next/link";
import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";

export default function TemaMesSection() {
  return (
    <section className="bg-ibk-dark-surface py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10">
      <div className="max-w-7xl mx-auto">

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

          {/* Versículo + Tema */}
          <div>
            <FadeIn>
              <div className="flex items-center gap-3 mb-8">
                <span className="w-6 h-px bg-[#E84C1E]" />
                <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                  {COPY.tema.eyebrow}
                </span>
              </div>
            </FadeIn>

            <FadeIn delay={0.08}>
              <h2 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-[0.95] tracking-tight mb-10">
                {COPY.tema.linha1}<br />
                <span className="font-serif italic text-white/90">{COPY.tema.linha2}</span>
              </h2>
            </FadeIn>

            <FadeIn delay={0.16}>
              <blockquote className="border-l-2 border-[#E84C1E]/60 pl-6 mb-8">
                <p className="font-serif italic text-white/90 text-lg leading-relaxed mb-3">
                  &ldquo;{COPY.tema.versiculo}&rdquo;
                </p>
                <cite className="text-[#E84C1E] font-display font-bold text-sm not-italic">
                  {COPY.tema.referencia}
                </cite>
              </blockquote>
            </FadeIn>

            <FadeIn delay={0.24}>
              <Link
                href="/sobre"
                className="inline-flex items-center gap-2 text-white/65 font-display font-bold text-sm hover:text-[#E84C1E] active:text-[#E84C1E] transition-colors group"
              >
                Conheça nossa mensagem
                <ArrowRight size={14} className="group-hover:translate-x-1 group-active:translate-x-1 transition-transform" />
              </Link>
            </FadeIn>
          </div>

          {/* Cards de Valores */}
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {COPY.sobre.valores.map((v, i) => (
              <FadeIn key={v.titulo} delay={0.1 + i * 0.07} direction="left">
                <div className="group relative overflow-hidden border border-white/10 rounded p-5 bg-ibk-dark-card hover:border-[#E84C1E]/50 active:border-[#E84C1E]/50 hover:bg-[#261510] active:bg-[#261510] hover:-translate-y-1 hover:scale-[1.03] active:scale-[0.97] transition-all duration-[250ms] ease-[cubic-bezier(0.16,1,0.3,1)]">
                  <div className="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#E84C1E] to-transparent opacity-0 group-hover:opacity-100 group-active:opacity-100 transition-opacity" />
                  <span className="text-[#E84C1E] text-xl block mb-3">{v.icone}</span>
                  <h4 className="font-display font-extrabold text-white text-sm uppercase tracking-widest mb-2 group-hover:text-[#E84C1E] group-active:text-[#E84C1E] transition-colors">
                    {v.titulo}
                  </h4>
                  <p className="text-white/65 font-body text-xs leading-relaxed">{v.texto}</p>
                </div>
              </FadeIn>
            ))}
          </div>

        </div>
      </div>
    </section>
  );
}
