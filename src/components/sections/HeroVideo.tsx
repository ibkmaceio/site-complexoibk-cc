"use client";

import { useEffect, useRef, useState } from "react";

export default function HeroVideo() {
  const videoRef = useRef<HTMLVideoElement>(null);
  const [src, setSrc] = useState<string | null>(null);

  useEffect(() => {
    const mql = window.matchMedia("(min-width: 768px)");
    const resolve = () =>
      setSrc(mql.matches ? "/assets/video/hero-desktop.mp4" : "/assets/video/hero-mobile.mp4");
    resolve();
    mql.addEventListener("change", resolve);
    return () => mql.removeEventListener("change", resolve);
  }, []);

  useEffect(() => {
    const video = videoRef.current;
    if (!video || !src) return;
    video.load();
    const tryPlay = () => video.play().catch(() => {});
    tryPlay();
    video.addEventListener("canplay", tryPlay, { once: true });
    return () => video.removeEventListener("canplay", tryPlay);
  }, [src]);

  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none bg-ibk-dark-deep">
      <video
        ref={videoRef}
        autoPlay
        muted
        loop
        playsInline
        preload="auto"
        className="hero-video"
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
        }}
        src={src ?? undefined}
      />
    </div>
  );
}
