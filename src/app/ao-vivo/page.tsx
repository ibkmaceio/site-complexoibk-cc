import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import AoVivoPlayer from "./AoVivoPlayer";

export const metadata: Metadata = {
  title: "Ao Vivo",
  description: "Assista ao culto ao vivo da IBK Maceió agora mesmo. Igreja Batista Koinonia — domingos às 9h e 18h30, quartas às 19h30.",
  openGraph: {
    title: "Culto ao vivo agora — IBK Maceió",
    description: "Assista à transmissão da Igreja Batista Koinonia em Maceió, AL.",
    images: [
      {
        url: "https://ibkmaceio.com.br/assets/og/og-ao-vivo.png",
        width: 1200,
        height: 630,
        alt: "Culto ao vivo — IBK Maceió",
      },
    ],
  },
  twitter: {
    card: "summary_large_image",
    title: "Culto ao vivo agora — IBK Maceió",
    description: "Assista à transmissão da Igreja Batista Koinonia em Maceió, AL.",
    images: ["https://ibkmaceio.com.br/assets/og/og-ao-vivo.png"],
  },
};

export default function AoVivoPage() {
  return (
    <PageShell>
      <AoVivoPlayer />
    </PageShell>
  );
}
