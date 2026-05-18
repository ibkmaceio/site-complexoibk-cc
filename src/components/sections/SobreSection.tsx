import Link from "next/link";
import { ArrowRight, Heart, Users, Sparkles, Users2, Shield, Gift } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";

const VALOR_ICONS = [Heart, Users, Sparkles, Users2, Shield, Gift];

interface SobreSectionProps {
  asH1?: boolean;
}

export default function SobreSection({ asH1 = false }: SobreSectionProps) {
  const Heading = asH1 ? "h1" : "h2";

  return (
    <section className="bg-ibk-dark-surface py-16 sm:py-20 lg:py-28 px-4 sm:px-6 lg:px-8">
      <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-20 items-center">

        {/* Texto */}
        <div>
          <FadeIn>
            <div className="flex items-center gap-3 mb-8">
              <span className="w-6 h-px bg-[#D4521A]" />
              <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                {COPY.sobre.eyebrow}
              </span>
            </div>
          </FadeIn>

          <FadeIn delay={0.1}>
            <Heading className="font-display font-black text-[clamp(2.2rem,4.5vw,3.8rem)] text-white leading-[1.05] tracking-tight mb-8">
              Uma comunidade que{" "}
              <span className="font-serif italic text-[#D4521A]">transforma vidas</span>{" "}
              em Maceió.
            </Heading>
          </FadeIn>

          <FadeIn delay={0.2}>
            <div className="space-y-4 mb-10">
              {COPY.sobre.paragrafos.map((p, i) => (
                <p key={i} className="text-white/90 font-body text-base leading-relaxed">
                  {p}
                </p>
              ))}
            </div>
          </FadeIn>

          <FadeIn delay={0.3}>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
              {[COPY.sobre.missao, COPY.sobre.visao].map((item) => (
                <div key={item.titulo} className="border-l border-[#D4521A]/40 pl-4">
                  <h4 className="font-display font-extrabold text-white text-sm uppercase tracking-widest mb-2">
                    {item.titulo}
                  </h4>
                  <p className="text-white/65 font-body text-sm leading-relaxed">
                    {item.texto}
                  </p>
                </div>
              ))}
            </div>
          </FadeIn>

          <FadeIn delay={0.4}>
            <Link
              href="/nossa-historia"
              className="inline-flex items-center gap-2 text-white font-display font-bold text-sm hover:text-[#D4521A] active:text-[#D4521A] transition-colors group"
            >
              {COPY.sobre.cta}
              <ArrowRight size={16} className="group-hover:translate-x-1 group-active:translate-x-1 transition-transform" />
            </Link>
          </FadeIn>
        </div>

        {/* Foto + Valores */}
        <div className="space-y-4">
          <FadeIn direction="left">
            <div className="relative aspect-[4/3] bg-ibk-dark-surface rounded overflow-hidden">
              <div
                role="img"
                aria-label="Comunidade IBK — 8 anos de fé e fraternidade em Maceió"
                className="absolute inset-0 bg-cover bg-center"
                style={{ backgroundImage: "url('/assets/img/ibk-maceio-comunidade-fraternidade-8-anos.webp')" }}
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent" />
              <div className="absolute bottom-5 left-5 right-5">
                <p className="text-white/90 font-body text-sm leading-relaxed">
                  Comunidade IBK — 8 anos de fé e fraternidade em Maceió
                </p>
              </div>
            </div>
          </FadeIn>

          <FadeIn delay={0.15} direction="left">
            <div className="grid grid-cols-2 sm:grid-cols-3 gap-3">
              {COPY.sobre.valores.map((v, i) => {
                const Icon = VALOR_ICONS[i];
                return (
                  <div
                    key={v.titulo}
                    className="group relative overflow-hidden bg-ibk-dark-card border border-white/12 rounded p-4 hover:border-[#D4521A]/50 active:border-[#D4521A]/50 hover:bg-[#261510] active:bg-[#261510] hover:-translate-y-1 active:-translate-y-1 hover:scale-[1.03] active:scale-[0.97] transition-all duration-[250ms] ease-[cubic-bezier(0.16,1,0.3,1)]"
                  >
                    <div className="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#D4521A] to-transparent opacity-0 group-hover:opacity-100 group-active:opacity-100 transition-opacity" />
                    <div className="w-8 h-8 flex items-center justify-center rounded bg-[#D4521A]/15 mb-3">
                      <Icon size={16} stroke="#D4521A" strokeWidth={1.5} />
                    </div>
                    <h5 className="font-display font-extrabold text-white text-xs uppercase tracking-widest mb-1">{v.titulo}</h5>
                    <p className="text-white/55 font-body text-xs leading-relaxed">{v.texto}</p>
                  </div>
                );
              })}
            </div>
          </FadeIn>
        </div>
      </div>
    </section>
  );
}
