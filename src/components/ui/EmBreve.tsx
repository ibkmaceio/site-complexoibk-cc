import Link from "next/link";
import { CHURCH_INFO } from "@/lib/data/mock";

export default function EmBreve({ titulo }: { titulo: string }) {
  return (
    <section className="py-40 px-6 text-center">
      <span className="w-6 h-px bg-[#D4521A] inline-block mb-8" />
      <h1 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight mb-4">
        {titulo}
      </h1>
      <p className="text-white/65 font-body text-base max-w-sm mx-auto mb-4">
        Esta seção estará disponível em breve.
      </p>
      <p className="text-white/50 font-body text-sm max-w-sm mx-auto mb-10">
        Acompanhe nossas redes para novidades da IBK Maceió.
      </p>
      <div className="flex items-center justify-center gap-4 mb-10">
        <a
          href={CHURCH_INFO.instagram}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-[#D4521A] text-white text-sm font-display font-bold rounded transition-colors"
          aria-label="Instagram IBK Maceió"
        >
          Instagram
        </a>
        <a
          href={CHURCH_INFO.youtube}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-[#D4521A] text-white text-sm font-display font-bold rounded transition-colors"
          aria-label="YouTube IBK Maceió"
        >
          YouTube
        </a>
      </div>
      <Link
        href="/"
        className="inline-flex items-center gap-2 text-white/60 hover:text-white font-display font-bold text-sm transition-colors"
      >
        ← Voltar para o início
      </Link>
    </section>
  );
}
