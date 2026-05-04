import type { Metadata } from "next";
import Script from "next/script";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import HeroSection from "@/components/sections/HeroSection";
import TemaMesSection from "@/components/sections/TemaMesSection";
import MissaoSection from "@/components/sections/MissaoSection";
import ProgramacaoSection from "@/components/sections/ProgramacaoSection";
import NoticiasSection from "@/components/sections/NoticiasSection";
import VideosSection from "@/components/sections/VideosSection";
import PregacoesSection from "@/components/sections/PregacoesSection";
import DoacoesSection from "@/components/sections/DoacoesSection";
import { CHURCH_INFO } from "@/lib/data/mock";

export const metadata: Metadata = {
  title: "IBK — Igreja Batista Koinonia | Maceió, Alagoas",
  description:
    "Você foi feito para pertencer. Igreja Batista Koinonia em Maceió, Alagoas — cultos, TV IBK ao vivo, eventos e comunidade.",
  openGraph: {
    title: "IBK — Igreja Batista Koinonia | Maceió, Alagoas",
    description: "Igreja Batista Koinonia em Maceió, Alagoas. Cultos, eventos, ministérios e TV IBK ao vivo.",
    url: "https://ibkmaceio.com.br",
    images: [
      {
        url: "https://ibkmaceio.com.br/assets/og/og-ibkmaceio-v2.png",
        width: 1200,
        height: 630,
        alt: "IBK — Igreja Batista Koinonia Maceió",
      },
    ],
  },
};

export default function HomePage() {
  const schemaOrg = JSON.stringify({
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": ["Church", "LocalBusiness"],
        "@id": "https://ibkmaceio.com.br/#church",
        name: "Igreja Batista Koinonia Maceió",
        alternateName: ["IBK Maceió", "IBK", "Koinonia Maceió"],
        description: "Igreja Batista Koinonia em Maceió, Alagoas. Comunidade cristã comprometida com o amor a Deus e ao próximo.",
        url: "https://ibkmaceio.com.br",
        logo: "https://ibkmaceio.com.br/assets/logo/logo-original-horizontal.png",
        address: { "@type": "PostalAddress", addressLocality: "Maceió", addressRegion: "AL", addressCountry: "BR" },
        geo: { "@type": "GeoCoordinates", latitude: CHURCH_INFO.coordinates.lat, longitude: CHURCH_INFO.coordinates.lng },
        hasMap: `https://www.google.com/maps/place/?q=place_id:${CHURCH_INFO.placeId}`,
        sameAs: [CHURCH_INFO.instagram, CHURCH_INFO.youtube],
        openingHoursSpecification: [
          { "@type": "OpeningHoursSpecification", dayOfWeek: "Sunday", opens: "09:00", closes: "20:30" },
          { "@type": "OpeningHoursSpecification", dayOfWeek: "Wednesday", opens: "19:30", closes: "21:30" },
          { "@type": "OpeningHoursSpecification", dayOfWeek: "Saturday", opens: "18:00", closes: "20:00" },
        ],
      },
      {
        "@type": "WebSite",
        "@id": "https://ibkmaceio.com.br/#website",
        url: "https://ibkmaceio.com.br",
        name: "IBK — Igreja Batista Koinonia Maceió",
        publisher: { "@id": "https://ibkmaceio.com.br/#church" },
        inLanguage: "pt-BR",
      },
    ],
  });

  return (
    <>
      <Script id="schema-church" type="application/ld+json" strategy="beforeInteractive">
        {schemaOrg}
      </Script>
      <Header />
      <main id="main-content">
        <HeroSection />
        <TemaMesSection />
        <MissaoSection />
        <ProgramacaoSection />
        <NoticiasSection />
        <VideosSection />
        <PregacoesSection />
        <DoacoesSection />
      </main>
      <Footer />
    </>
  );
}
