import Link from "next/link";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Página não encontrada | IBK Maceió",
};

export default function NotFound() {
  return (
    <div className="min-h-screen bg-[#080808] flex flex-col items-center justify-center px-6 text-center">
      <span className="font-display font-900 text-[8rem] leading-none text-white/5 select-none">
        404
      </span>
      <h1 className="font-display font-900 text-3xl text-white mt-2 mb-4">
        Página não encontrada
      </h1>
      <p className="text-white/50 font-body text-base max-w-sm mb-10">
        O endereço que você acessou não existe ou foi movido.
      </p>
      <Link
        href="/"
        className="inline-flex items-center gap-2 px-6 py-3 bg-[#D4521A] hover:bg-[#B34215] text-white font-display font-700 text-sm rounded transition-colors"
      >
        Voltar para o início
      </Link>
    </div>
  );
}
