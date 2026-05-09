import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import FadeIn from "@/components/ui/FadeIn";
import { PROGRAMACAO } from "@/lib/data/mock";
import { COPY } from "@/lib/data/copy";

export const metadata: Metadata = {
  title: "Programação",
  description: "Horários dos cultos da IBK Maceió: domingos às 9h e 18h30, quartas às 19h30 e sábados às 18h. Você e sua família são sempre bem-vindos!",
};

export default function ProgramacaoPage() {
  return (
    <PageShell>
      <section className="bg-ibk-dark-surface px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-28">
        <div className="max-w-7xl mx-auto">

          {/* Header */}
          <FadeIn>
            <div className="flex items-center gap-3 mb-6">
              <span className="w-6 h-px bg-[#D4521A]" />
              <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                {COPY.programacao.eyebrow}
              </span>
            </div>
            <h1 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight tracking-tight mb-4">
              {COPY.programacao.headline}
            </h1>
            <p className="text-white/65 font-body text-sm leading-relaxed max-w-lg mb-14">
              {COPY.programacao.subline}
            </p>
          </FadeIn>

          {/* Cards */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {PROGRAMACAO.flatMap((dia) =>
              dia.cultos.map((culto, i) => (
                <FadeIn key={`${dia.dia}-${i}`} delay={i * 0.08}>
                  <div className="group relative overflow-hidden border border-white/10 rounded p-6 bg-ibk-dark-card hover:border-[#D4521A]/50 active:border-[#D4521A]/50 hover:bg-[#2e1a0e] active:bg-[#2e1a0e] hover:-translate-y-1 hover:scale-[1.03] active:scale-[0.97] transition-all duration-[250ms] ease-[cubic-bezier(0.16,1,0.3,1)]">
                    <div className="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#D4521A] to-transparent opacity-0 group-hover:opacity-100 group-active:opacity-100 transition-opacity" />
                    <span className="font-display font-extrabold text-[10px] uppercase tracking-[0.25em] text-white/65 block mb-4">
                      {dia.dia}
                    </span>
                    <h2 className="font-display font-extrabold text-xl text-white mb-3 group-hover:text-[#D4521A] group-active:text-[#D4521A] transition-colors">
                      {culto.nome}
                    </h2>
                    <p className="font-display font-bold text-3xl text-white/40">
                      {culto.horario}
                    </p>
                  </div>
                </FadeIn>
              ))
            )}
          </div>

        </div>
      </section>
    </PageShell>
  );
}
