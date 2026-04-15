"use client";

import { useState, useEffect, useRef } from "react";

const VIDEO_ID = "WfIY1iTRjPg";
const SRC = `https://www.youtube-nocookie.com/embed/${VIDEO_ID}?autoplay=1&mute=1&loop=1&playlist=${VIDEO_ID}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&disablekb=1&iv_load_policy=3`;
const POSTER = `https://i.ytimg.com/vi_webp/${VIDEO_ID}/maxresdefault.webp`;

export default function HeroVideo() {
  const [loaded, setLoaded] = useState(false);
  const [ready, setReady] = useState(false);
  const containerRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    setLoaded(true);
  }, []);

  return (
    <div ref={containerRef} className="absolute inset-0 overflow-hidden pointer-events-none">
      <img
        src={POSTER}
        alt=""
        aria-hidden="true"
        fetchPriority="high"
        decoding="async"
        style={{
          position: "absolute",
          top: "50%",
          left: "50%",
          width: "100vw",
          height: "56.25vw",
          minHeight: "100%",
          minWidth: "177.78vh",
          transform: "translate(-50%, -50%)",
          objectFit: "cover",
          opacity: ready ? 0 : 1,
          transition: "opacity 600ms ease",
        }}
      />
      {loaded && (
        <iframe
          src={SRC}
          allow="autoplay; encrypted-media"
          loading="eager"
          onLoad={() => setReady(true)}
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
            opacity: ready ? 1 : 0,
            transition: "opacity 600ms ease",
          }}
          title="IBK — Vídeo Hero"
        />
      )}
    </div>
  );
}
