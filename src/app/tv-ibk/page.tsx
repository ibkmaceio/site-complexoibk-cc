import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import VideosSection from "@/components/sections/VideosSection";

export const metadata: Metadata = {
  title: "TV IBK",
  description: "Assista pregações, cultos e conteúdo da Igreja Batista Koinonia em Maceió na TV IBK — vídeos novos toda semana.",
};

export default function TvIbkPage() {
  return (
    <PageShell>
      <VideosSection />
    </PageShell>
  );
}
