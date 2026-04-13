"use client";

import { useState, useEffect } from "react";

const SRC =
  "https://www.youtube.com/embed/mvILffB2f5A?autoplay=1&mute=1&loop=1&playlist=mvILffB2f5A&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&disablekb=1&iv_load_policy=3";

export default function HeroVideo() {
  const [src, setSrc] = useState("");

  useEffect(() => {
    // Carrega o iframe só após o browser estar idle — não bloqueia LCP
    const load = () => setSrc(SRC);
    if ("requestIdleCallback" in window) {
      (window as Window & typeof globalThis).requestIdleCallback(load, { timeout: 3000 });
    } else {
      setTimeout(load, 2000);
    }
  }, []);

  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none">
      {src && (
        <iframe
          src={src}
          allow="autoplay; encrypted-media"
          style={{
            position: "absolute",
            top: "50%",
            left: "50%",
            width: "100vw",
            height: "56.25vw",
            minHeight: "100%",
            minWidth: "177.78vh",
            transform: "translate(-50%, -50%)",
            border: 0,
          }}
          title="IBK — Vídeo Hero"
        />
      )}
    </div>
  );
}
