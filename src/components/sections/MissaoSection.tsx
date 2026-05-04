import Link from "next/link";
import { ArrowRight } from "lucide-react";
import FadeIn from "@/components/ui/FadeIn";
import { COPY } from "@/lib/data/copy";

export default function MissaoSection() {
  return (
    <section className="bg-ibk-dark py-16 sm:py-20 px-4 sm:px-6 lg:px-8 border-y border-white/5">
      <div className="max-w-4xl mx-auto text-center">
        <FadeIn>
          <div className="flex items-center justify-center gap-3 mb-6">
            <span className="w-6 h-px bg-[#D4521A]" />
            <span className="text-white/50 text-xs font-body uppercase tracking-[0.2em]">
              {COPY.sobre.missao.titulo}
            </span>
            <span className="w-6 h-px bg-[#D4521A]" />
          </div>
        </FadeIn>

        <FadeIn delay={0.1}>
          <p className="font-display font-bold text-[clamp(1.15rem,2.5vw,1.6rem)] text-white/90 leading-relaxed mb-10 max-w-3xl mx-auto">
            &ldquo;{COPY.sobre.missao.texto}&rdquo;
          </p>
        </FadeIn>

        <FadeIn delay={0.2}>
          <Link
            href="/sobre"
            className="inline-flex items-center gap-2 text-[#D4521A] font-display font-bold text-sm hover:text-white active:text-white transition-colors group"
          >
            Conheça a IBK
            <ArrowRight size={15} className="group-hover:translate-x-1 group-active:translate-x-1 transition-transform" />
          </Link>
        </FadeIn>
      </div>
    </section>
  );
}
