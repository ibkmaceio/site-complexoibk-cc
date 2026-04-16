import type { Metadata } from "next";
import { Outfit, DM_Sans, Cormorant_Garamond } from "next/font/google";
import "./globals.css";
import ScrollProgress from "@/components/ui/ScrollProgress";

const outfit = Outfit({
  variable: "--font-outfit",
  subsets: ["latin"],
  weight: ["400", "600", "700", "800", "900"],
  display: "swap",
  adjustFontFallback: true,
  preload: true,
});

const dmSans = DM_Sans({
  variable: "--font-dm-sans",
  subsets: ["latin"],
  weight: ["400", "500", "600"],
  display: "swap",
  adjustFontFallback: true,
  preload: true,
});

const cormorant = Cormorant_Garamond({
  variable: "--font-cormorant",
  subsets: ["latin"],
  weight: ["400", "700"],
  style: ["normal", "italic"],
  display: "swap",
  adjustFontFallback: true,
  preload: true,
});

export const metadata: Metadata = {
  metadataBase: new URL("https://ibkmaceio.com.br"),
  title: {
    default: "IBK — Igreja Batista Koinonia | Maceió, Alagoas",
    template: "%s | IBK Maceió",
  },
  description:
    "Igreja Batista Koinonia em Maceió, Alagoas. Cultos, eventos, ministérios, TV IBK ao vivo e muito mais. Venha fazer parte da nossa família!",
  keywords: [
    "ibk",
    "igreja maceió",
    "igreja batista maceió",
    "koinonia maceió",
    "igreja evangélica maceió",
    "culto maceió",
    "igreja alagoas",
    "igreja batista alagoas",
    "ibk maceió",
    "igreja koinonia",
  ],
  authors: [{ name: "Igreja Batista Koinonia" }],
  creator: "IBK Maceió",
  openGraph: {
    type: "website",
    locale: "pt_BR",
    url: "https://ibkmaceio.com.br",
    siteName: "IBK — Igreja Batista Koinonia Maceió",
    title: "IBK — Igreja Batista Koinonia | Maceió, Alagoas",
    description:
      "Igreja Batista Koinonia em Maceió, Alagoas. Cultos, eventos, ministérios e TV IBK ao vivo.",
    images: [
      {
        url: "https://ibkmaceio.com.br/assets/og/og-default.png",
        width: 1200,
        height: 630,
        alt: "IBK — Igreja Batista Koinonia Maceió",
      },
    ],
  },
  twitter: {
    card: "summary_large_image",
    title: "IBK — Igreja Batista Koinonia | Maceió, Alagoas",
    description:
      "Igreja Batista Koinonia em Maceió, Alagoas. Cultos, eventos, ministérios e TV IBK ao vivo.",
    images: ["https://ibkmaceio.com.br/assets/og/og-default.png"],
  },
  alternates: {
    canonical: "https://ibkmaceio.com.br",
  },
  robots: {
    index: true,
    follow: true,
    googleBot: {
      index: true,
      follow: true,
      "max-video-preview": -1,
      "max-image-preview": "large",
      "max-snippet": -1,
    },
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html
      lang="pt-BR"
      className={`${outfit.variable} ${dmSans.variable} ${cormorant.variable} h-full`}
    >
      <head>
        <link rel="preconnect" href="https://www.youtube-nocookie.com" crossOrigin="" />
        <link rel="preconnect" href="https://www.youtube.com" crossOrigin="" />
        <link rel="preconnect" href="https://i.ytimg.com" crossOrigin="" />
        <link rel="preconnect" href="https://yt3.ggpht.com" crossOrigin="" />
        <link rel="dns-prefetch" href="https://www.google.com" />
      </head>
      <body className="min-h-full flex flex-col antialiased" suppressHydrationWarning>
        <ScrollProgress />
        {children}
      </body>
    </html>
  );
}
