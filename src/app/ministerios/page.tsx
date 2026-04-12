import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Ministérios",
  description: "Conheça os ministérios da Igreja Batista Koinonia em Maceió, Alagoas.",
};

export default function MisteriosPage() {
  return (
    <PageShell>
      <EmBreve titulo="Ministérios" />
    </PageShell>
  );
}
