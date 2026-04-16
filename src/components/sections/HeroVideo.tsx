"use client";

import { useState, useEffect } from "react";

const VIDEO_ID = "WfIY1iTRjPg";
const YT_SRC = `https://www.youtube-nocookie.com/embed/${VIDEO_ID}?autoplay=1&mute=1&loop=1&playlist=${VIDEO_ID}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&disablekb=1&iv_load_policy=3`;

const iframeStyle: React.CSSProperties = {
  position: "absolute",
  top: "50%",
  left: "50%",
  width: "100vw",
  height: "56.25vw",
  minHeight: "100%",
  minWidth: "177.78vh",
  transform: "translate(-50%, -50%)",
  border: 0,
};

export default function HeroVideo() {
  const [isMobile, setIsMobile] = useState(false);

  useEffect(() => {
    setIsMobile(window.innerWidth < 768);
  }, []);

  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none bg-ibk-dark-deep">
      {isMobile ? (
        <video
          autoPlay
          muted
          loop
          playsInline
          preload="metadata"
          className="hero-video"
          style={{ ...iframeStyle, objectFit: "cover" }}
        >
          <source src="/assets/video/hero.mp4" type="video/mp4" />
        </video>
      ) : (
        <iframe
          src={YT_SRC}
          allow="autoplay; encrypted-media"
          loading="eager"
          className="hero-video"
          style={iframeStyle}
          title="IBK — Vídeo Hero"
        />
      )}
    </div>
  );
}
