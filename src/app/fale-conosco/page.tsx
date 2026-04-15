import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Fale Conosco",
  description: "Fale com a Igreja Batista Koinonia em Maceió, AL. Pedidos de oração, primeira visita ou dúvidas — nossa equipe responde com carinho.",
};

export default function FaleConoscoPage() {
  return (
    <PageShell>
      <EmBreve titulo="Fale Conosco" />
    </PageShell>
  );
}
