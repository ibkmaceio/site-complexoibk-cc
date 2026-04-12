import type { Metadata } from "next";
import { notFound } from "next/navigation";
import Link from "next/link";
import PageShell from "@/components/layout/PageShell";
import { NOTICIAS } from "@/lib/data/mock";

export function generateStaticParams() {
  return NOTICIAS.map((n) => ({ slug: n.slug }));
}

export async function generateMetadata({
  params,
}: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await params;
  const noticia = NOTICIAS.find((n) => n.slug === slug);
  if (!noticia) return {};
  return {
    title: noticia.titulo,
    description: noticia.resumo,
  };
}

function formatDate(d: string) {
  return new Date(d).toLocaleDateString("pt-BR", {
    day: "2-digit",
    month: "long",
    year: "numeric",
  });
}

export default async function NoticiaPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  const noticia = NOTICIAS.find((n) => n.slug === slug);
  if (!noticia) notFound();

  return (
    <PageShell>
      <article className="max-w-3xl mx-auto px-6 py-20">
        <Link
          href="/novidades"
          className="text-white/40 hover:text-white font-body text-sm transition-colors mb-10 inline-block"
        >
          ← Novidades
        </Link>

        <div className="flex items-center gap-3 mb-6">
          <span className="badge-accent">{noticia.tag}</span>
          <span className="text-white/35 font-body text-sm">{formatDate(noticia.data)}</span>
        </div>

        <h1 className="font-display font-900 text-[clamp(2rem,4vw,3rem)] text-white leading-tight mb-6">
          {noticia.titulo}
        </h1>

        {noticia.imagem && (
          <div
            className="w-full aspect-[16/9] rounded bg-cover bg-center bg-[#111] mb-10"
            style={{ backgroundImage: `url('${noticia.imagem}')` }}
          />
        )}

        <p className="text-white/70 font-body text-base leading-relaxed">
          {noticia.resumo}
        </p>
      </article>
    </PageShell>
  );
}
