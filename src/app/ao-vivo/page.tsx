import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import AoVivoPlayer from "./AoVivoPlayer";

export const metadata: Metadata = {
  title: "Ao Vivo",
  description: "Assista ao culto ao vivo da Igreja Batista Koinonia em Maceió.",
};

export default function AoVivoPage() {
  return (
    <PageShell>
      <AoVivoPlayer />
    </PageShell>
  );
}
