import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Galeria de Fotos",
  description: "Galeria de fotos e momentos da Igreja Batista Koinonia em Maceió.",
};

export default function MidiaPage() {
  return (
    <PageShell>
      <EmBreve titulo="Galeria" />
    </PageShell>
  );
}
