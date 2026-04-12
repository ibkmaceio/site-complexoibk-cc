import Link from "next/link";
import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";
import { DOACOES } from "@/lib/data/mock";

export default function DoacoesSection() {
  return (
    <section className="relative overflow-hidden bg-[#080808] py-28 px-6 sm:px-10 lg:px-16 border-t border-white/5">

      {/* Foto de fundo sutil */}
      <div
        className="absolute inset-0 bg-cover bg-center opacity-10"
        style={{ backgroundImage: "url('/assets/img/dizimos.jpg')" }}
      />
      <div className="absolute inset-0 bg-gradient-to-b from-[#080808] via-transparent to-[#080808]" />

      <div className="relative z-10 max-w-7xl mx-auto">

        {/* Versículo em destaque */}
        <FadeIn>
          <div className="text-center mb-20">
            <p className="font-serif italic text-white/50 text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed mb-3">
              &ldquo;{COPY.dizimos.versiculoTexto}&rdquo;
            </p>
            <span className="text-[#E84C1E] font-display font-700 text-sm">{COPY.dizimos.versiculoRef}</span>
          </div>
        </FadeIn>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

          {/* Texto */}
          <div>
            <FadeIn>
              <div className="flex items-center gap-3 mb-6">
                <span className="w-6 h-px bg-[#E84C1E]" />
                <span className="text-white/50 text-xs font-body uppercase tracking-[0.2em]">
                  {COPY.dizimos.eyebrow}
                </span>
              </div>
              <h2 className="font-display font-900 text-[clamp(2rem,4vw,3.5rem)] text-white leading-tight tracking-tight mb-6">
                {COPY.dizimos.headline}
              </h2>
              <p className="text-white/55 font-body text-base leading-relaxed mb-10">
                {COPY.dizimos.subline}
              </p>
            </FadeIn>

            {/* PIX */}
            <FadeIn delay={0.1}>
              <div className="flex items-center gap-4 p-5 border border-white/10 rounded bg-white/3 mb-6">
                <div className="w-10 h-10 flex items-center justify-center rounded bg-[#E84C1E]/15 shrink-0">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E84C1E" strokeWidth="1.5">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/><rect x="17" y="17" width="4" height="4"/>
                  </svg>
                </div>
                <div>
                  <span className="font-display font-800 text-[10px] uppercase tracking-[0.2em] text-white/30 block">
                    {COPY.dizimos.ctaPix}
                  </span>
                  <span className="font-display font-700 text-white text-sm">{DOACOES.pix}</span>
                </div>
              </div>
            </FadeIn>

            <FadeIn delay={0.2}>
              <Link
                href="/doacoes"
                className="inline-flex items-center gap-2 text-white font-display font-700 text-sm hover:text-[#E84C1E] transition-colors group"
              >
                {COPY.dizimos.ctaDetalhes}
                <ArrowRight size={15} className="group-hover:translate-x-1 transition-transform" />
              </Link>
            </FadeIn>
          </div>

          {/* Grid bancos */}
          <div className="grid grid-cols-2 gap-3">
            {DOACOES.bancos.map((banco, i) => (
              <FadeIn key={banco.banco} delay={i * 0.07} direction="left">
                <div className="p-5 border border-white/8 rounded bg-[#111] hover:border-[#E84C1E]/30 transition-colors">
                  <span className="font-display font-800 text-[10px] uppercase tracking-widest text-white/30 block mb-3">
                    {banco.banco}
                  </span>
                  <p className="font-body text-xs text-white/60 leading-relaxed">
                    Ag. <span className="text-white font-600">{banco.agencia}</span><br />
                    Cc. <span className="text-white font-600">{banco.conta}</span>
                  </p>
                </div>
              </FadeIn>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
