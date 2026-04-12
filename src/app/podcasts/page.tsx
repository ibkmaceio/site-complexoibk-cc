import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import EmBreve from "@/components/ui/EmBreve";

export const metadata: Metadata = {
  title: "Podcasts",
  description: "Ouça os podcasts e mensagens da Igreja Batista Koinonia.",
};

export default function PodcastsPage() {
  return (
    <PageShell>
      <EmBreve titulo="Podcasts" />
    </PageShell>
  );
}
