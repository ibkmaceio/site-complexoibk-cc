import Link from "next/link";
import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";

export default function SobreSection() {
  return (
    <section className="bg-[#0d0d0d] py-28 px-6 sm:px-10 lg:px-16">
      <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">

        {/* Texto */}
        <div>
          <FadeIn>
            <div className="flex items-center gap-3 mb-8">
              <span className="w-6 h-px bg-[#E84C1E]" />
              <span className="text-white/50 text-xs font-body uppercase tracking-[0.2em]">
                {COPY.sobre.eyebrow}
              </span>
            </div>
          </FadeIn>

          <FadeIn delay={0.1}>
            <h2 className="font-display font-900 text-[clamp(2.2rem,4.5vw,3.8rem)] text-white leading-[1.05] tracking-tight mb-8">
              {COPY.sobre.headline}
            </h2>
          </FadeIn>

          <FadeIn delay={0.2}>
            <div className="space-y-4 mb-10">
              {COPY.sobre.paragrafos.map((p, i) => (
                <p key={i} className="text-white/60 font-body text-base leading-relaxed">
                  {p}
                </p>
              ))}
            </div>
          </FadeIn>

          <FadeIn delay={0.3}>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
              {[COPY.sobre.missao, COPY.sobre.visao].map((item) => (
                <div key={item.titulo} className="border-l border-[#E84C1E]/30 pl-4">
                  <h4 className="font-display font-800 text-white text-sm uppercase tracking-widest mb-2">
                    {item.titulo}
                  </h4>
                  <p className="text-white/55 font-body text-sm leading-relaxed">
                    {item.texto}
                  </p>
                </div>
              ))}
            </div>
          </FadeIn>

          <FadeIn delay={0.4}>
            <Link
              href="/nossa-historia"
              className="inline-flex items-center gap-2 text-white font-display font-700 text-sm hover:text-[#E84C1E] transition-colors group"
            >
              {COPY.sobre.cta}
              <ArrowRight size={16} className="group-hover:translate-x-1 transition-transform" />
            </Link>
          </FadeIn>
        </div>

        {/* Foto + Valores */}
        <div className="space-y-4">
          {/* Foto (user vai fornecer) */}
          <FadeIn direction="left">
            <div className="relative aspect-[4/3] bg-[#1a1a1a] rounded overflow-hidden">
              <div
                className="absolute inset-0 bg-cover bg-center"
                style={{ backgroundImage: "url('/assets/img/sobre.jpg')" }}
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" />
              {/* Placeholder visual */}
              <div className="absolute inset-0 flex items-center justify-center text-white/10 text-xs font-body">
                foto · sobre.jpg
              </div>
            </div>
          </FadeIn>

          {/* Valores */}
          <FadeIn delay={0.15} direction="left">
            <div className="grid grid-cols-2 gap-3">
              {COPY.sobre.valores.map((v) => (
                <div
                  key={v.titulo}
                  className="bg-[#1a1a1a] border border-white/5 rounded p-4 hover:border-[#E84C1E]/30 transition-colors"
                >
                  <span className="text-[#E84C1E] text-lg block mb-2">{v.icone}</span>
                  <h5 className="font-display font-800 text-white text-sm mb-1">{v.titulo}</h5>
                  <p className="text-white/45 font-body text-xs leading-relaxed">{v.texto}</p>
                </div>
              ))}
            </div>
          </FadeIn>
        </div>
      </div>
    </section>
  );
}
