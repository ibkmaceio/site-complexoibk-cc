import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import AoVivoPlayer from "./AoVivoPlayer";

export const metadata: Metadata = {
  title: "Ao Vivo",
  description: "Assista ao culto ao vivo da IBK Maceió agora mesmo. Igreja Batista Koinonia — domingos às 9h e 18h30, quartas às 19h30.",
};

export default function AoVivoPage() {
  return (
    <PageShell>
      <AoVivoPlayer />
    </PageShell>
  );
}
