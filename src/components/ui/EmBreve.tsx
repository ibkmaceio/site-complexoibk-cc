import Link from "next/link";

export default function EmBreve({ titulo }: { titulo: string }) {
  return (
    <section className="py-40 px-6 text-center">
      <span className="w-6 h-px bg-[#E84C1E] inline-block mb-8" />
      <h1 className="font-display font-black text-[clamp(2.5rem,5vw,4rem)] text-white leading-tight mb-4">
        {titulo}
      </h1>
      <p className="text-white/40 font-body text-base max-w-sm mx-auto mb-10">
        Esta página está sendo preparada.
      </p>
      <Link
        href="/"
        className="inline-flex items-center gap-2 text-white/60 hover:text-white font-display font-bold text-sm transition-colors"
      >
        ← Voltar para o início
      </Link>
    </section>
  );
}
