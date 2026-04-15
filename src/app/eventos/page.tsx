import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Eventos",
  description: "Confira a agenda completa de eventos da Igreja Batista Koinonia em Maceió, AL — cultos especiais, conferências, retiros e muito mais. Participe!",
};

export default function EventosPage() {
  return (
    <PageShell>
      <EmBreve titulo="Eventos" />
    </PageShell>
  );
}
