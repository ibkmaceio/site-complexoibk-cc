import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Nossa História",
  description: "A trajetória da Igreja Batista Koinonia em Maceió, Alagoas.",
};

export default function NossaHistoriaPage() {
  return (
    <PageShell>
      <EmBreve titulo="Nossa História" />
    </PageShell>
  );
}
