import type { MetadataRoute } from "next";

export default function manifest(): MetadataRoute.Manifest {
  return {
    name: "IBK — Igreja Batista Koinonia Maceió",
    short_name: "IBK Maceió",
    description: "Igreja Batista Koinonia em Maceió, Alagoas.",
    start_url: "/",
    display: "standalone",
    background_color: "#1A1A1A",
    theme_color: "#E84C1E",
    icons: [
      {
        src: "/icon-192.png",
        sizes: "192x192",
        type: "image/png",
      },
      {
        src: "/icon-512.png",
        sizes: "512x512",
        type: "image/png",
      },
    ],
  };
}
