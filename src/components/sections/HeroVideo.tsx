"use client";

import { useEffect, useRef } from "react";

export default function HeroVideo() {
  const videoRef = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    const video = videoRef.current;
    if (!video) return;

    video.muted = true;

    const tryPlay = () => {
      const p = video.play();
      if (p !== undefined) p.catch(() => {});
    };

    tryPlay();

    const onCanPlay = () => tryPlay();
    const onLoadedData = () => tryPlay();
    const onVisibility = () => {
      if (document.visibilityState === "visible") tryPlay();
    };
    const onUserGesture = () => tryPlay();

    video.addEventListener("canplay", onCanPlay);
    video.addEventListener("loadeddata", onLoadedData);
    document.addEventListener("visibilitychange", onVisibility);
    document.addEventListener("touchstart", onUserGesture, { once: true, passive: true });
    document.addEventListener("click", onUserGesture, { once: true });

    return () => {
      video.removeEventListener("canplay", onCanPlay);
      video.removeEventListener("loadeddata", onLoadedData);
      document.removeEventListener("visibilitychange", onVisibility);
      document.removeEventListener("touchstart", onUserGesture);
      document.removeEventListener("click", onUserGesture);
    };
  }, []);

  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none bg-ibk-dark-deep">
      <video
        ref={videoRef}
        autoPlay
        muted
        loop
        playsInline
        preload="auto"
        disablePictureInPicture
        disableRemotePlayback
        aria-hidden="true"
        tabIndex={-1}
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
      >
        <source
          src="/assets/video/hero-desktop.mp4"
          type="video/mp4"
          media="(min-width: 768px)"
        />
        <source src="/assets/video/hero-mobile.mp4" type="video/mp4" />
      </video>
    </div>
  );
}
