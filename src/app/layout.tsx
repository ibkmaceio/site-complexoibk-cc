import type { Metadata } from "next";
import { Nunito, Inter, Playfair_Display } from "next/font/google";
import "./globals.css";
import ScrollProgress from "@/components/ui/ScrollProgress";

const nunito = Nunito({
  variable: "--font-nunito",
  subsets: ["latin"],
  weight: ["400", "600", "700", "800", "900"],
  display: "swap",
});

const inter = Inter({
  variable: "--font-inter",
  subsets: ["latin"],
  weight: ["400", "500", "600"],
  display: "swap",
});

const playfair = Playfair_Display({
  variable: "--font-playfair",
  subsets: ["latin"],
  weight: ["400", "700"],
  style: ["normal", "italic"],
  display: "swap",
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
  },
  twitter: {
    card: "summary_large_image",
    title: "IBK — Igreja Batista Koinonia | Maceió, Alagoas",
    description:
      "Igreja Batista Koinonia em Maceió, Alagoas. Cultos, eventos, ministérios e TV IBK ao vivo.",
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
      className={`${nunito.variable} ${inter.variable} ${playfair.variable} h-full`}
    >
      <body className="min-h-full flex flex-col antialiased" suppressHydrationWarning>
        <ScrollProgress />
        {children}
      </body>
    </html>
  );
}
