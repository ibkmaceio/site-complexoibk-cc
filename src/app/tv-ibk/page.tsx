import type { Metadata } from "next";
import PageShell from "@/components/layout/PageShell";
import VideosSection from "@/components/sections/VideosSection";

export const metadata: Metadata = {
  title: "TV IBK",
  description: "Assista aos cultos e pregações da Igreja Batista Koinonia — TV IBK online.",
};

export default function TvIbkPage() {
  return (
    <PageShell>
      <VideosSection />
    </PageShell>
  );
}
