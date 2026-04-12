import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Eventos",
  description: "Agenda de eventos da Igreja Batista Koinonia em Maceió.",
};

export default function EventosPage() {
  return (
    <PageShell>
      <EmBreve titulo="Eventos" />
    </PageShell>
  );
}
