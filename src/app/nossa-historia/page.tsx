import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Nossa História",
  description: "Conheça a história de 8 anos da Igreja Batista Koinonia em Maceió, AL — de onde viemos, quem somos e para onde Deus nos leva.",
};

export default function NossaHistoriaPage() {
  return (
    <PageShell>
      <EmBreve titulo="Nossa História" />
    </PageShell>
  );
}
