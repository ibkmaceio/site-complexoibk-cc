import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Podcasts",
  description: "Ouça o IBKast — podcast da Igreja Batista Koinonia em Maceió com conversas sobre fé, liderança e vida cristã. Novos episódios toda semana.",
};

export default function PodcastsPage() {
  return (
    <PageShell>
      <EmBreve titulo="Podcasts" />
    </PageShell>
  );
}
