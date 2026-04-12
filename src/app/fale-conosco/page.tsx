import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Fale Conosco",
  description: "Entre em contato com a Igreja Batista Koinonia em Maceió, Alagoas.",
};

export default function FaleConoscoPage() {
  return (
    <PageShell>
      <EmBreve titulo="Fale Conosco" />
    </PageShell>
  );
}
