import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Voluntários",
  description: "Faça parte do time de voluntários da Igreja Batista Koinonia em Maceió.",
};

export default function VoluntariosPage() {
  return (
    <PageShell>
      <EmBreve titulo="Voluntários" />
    </PageShell>
  );
}
