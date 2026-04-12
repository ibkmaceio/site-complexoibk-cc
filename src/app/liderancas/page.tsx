import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Lideranças",
  description: "Conheça os pastores e líderes da Igreja Batista Koinonia em Maceió.",
};

export default function LiderancasPage() {
  return (
    <PageShell>
      <EmBreve titulo="Lideranças" />
    </PageShell>
  );
}
