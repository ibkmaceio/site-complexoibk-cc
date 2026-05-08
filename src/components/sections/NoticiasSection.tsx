import Link from "next/link";
import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";
import { NOTICIAS } from "@/lib/data/mock";

function formatDate(d: string) {
  return new Date(d).toLocaleDateString("pt-BR", { day: "2-digit", month: "short", year: "numeric" });
}

export default function NoticiasSection() {
  const [destaque, ...resto] = NOTICIAS;

  return (
    <section className="bg-ibk-dark-surface py-16 sm:py-20 lg:py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10">
      <div className="max-w-7xl mx-auto">

        <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16">
          <FadeIn>
            <div>
              <div className="flex items-center gap-3 mb-4">
                <span className="w-6 h-px bg-[#D4521A]" />
                <span className="text-white/65 text-xs font-body uppercase tracking-[0.2em]">
                  {COPY.novidades.eyebrow}
                </span>
              </div>
              <h2 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight tracking-tight">
                {COPY.novidades.headline}{" "}
                <span className="font-serif italic font-normal text-white/65">da IBK</span>
              </h2>
            </div>
          </FadeIn>
          <FadeIn delay={0.1}>
            <Link href="/novidades" className="flex items-center gap-2 text-white/65 hover:text-white active:text-white font-display font-bold text-sm transition-colors group shrink-0">
              {COPY.novidades.cta} <ArrowRight size={15} className="group-hover:translate-x-1 group-active:translate-x-1 transition-transform" />
            </Link>
          </FadeIn>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-5">

          {/* Destaque */}
          <FadeIn className="lg:col-span-7">
            <Link href={`/novidades/${destaque.slug}`} className="group block relative overflow-hidden rounded aspect-[16/10] bg-ibk-dark-surface">
              <div
                role="img"
                aria-label={destaque.titulo}
                className="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105 group-active:scale-105"
                style={{ backgroundImage: `url('${destaque.imagem}')` }}
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent" />

              <div className="absolute inset-0 z-10 flex flex-col justify-end p-8">
                <span className="badge-accent mb-3 self-start">{destaque.tag}</span>
                <h3 className="font-display font-extrabold text-2xl sm:text-3xl text-white leading-tight mb-2 group-hover:text-white/90 group-active:text-white/90 transition-colors">
                  {destaque.titulo}
                </h3>
                <p className="text-white/65 font-body text-sm line-clamp-2 mb-3">
                  {destaque.resumo}
                </p>
                <span className="text-white/40 font-body text-xs">{formatDate(destaque.data)}</span>
              </div>
            </Link>
          </FadeIn>

          {/* Lista lateral */}
          <div className="lg:col-span-5 flex flex-col gap-4">
            {resto.slice(0, 3).map((n, i) => (
              <FadeIn key={n.slug} delay={i * 0.08} direction="left">
                <Link href={`/novidades/${n.slug}`} className="group flex gap-4 p-4 rounded border border-white/10 bg-ibk-dark-card hover:border-[#D4521A]/40 active:border-[#D4521A]/40 hover:bg-[#2e1a0e] active:bg-[#2e1a0e] transition-all">
                  <div
                    role="img"
                    aria-label={n.titulo}
                    className="w-20 h-20 shrink-0 rounded overflow-hidden bg-ibk-dark-card bg-cover bg-center"
                    style={{ backgroundImage: `url('${n.imagem}')` }}
                  />
                  <div className="flex-1 min-w-0">
                    <span className="badge-accent text-[10px] px-1.5 py-0.5 mb-2 inline-block">{n.tag}</span>
                    <h4 className="font-display font-bold text-sm text-white/90 leading-snug line-clamp-2 group-hover:text-white group-active:text-white transition-colors">
                      {n.titulo}
                    </h4>
                    <span className="text-white/60 font-body text-xs mt-1 block">{formatDate(n.data)}</span>
                  </div>
                </Link>
              </FadeIn>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
