const VIDEO_ID = "WfIY1iTRjPg";
const SRC = `https://www.youtube-nocookie.com/embed/${VIDEO_ID}?autoplay=1&mute=1&loop=1&playlist=${VIDEO_ID}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&disablekb=1&iv_load_policy=3`;

export default function HeroVideo() {
  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none bg-ibk-dark-deep">
      <iframe
        src={SRC}
        allow="autoplay; encrypted-media"
        loading="eager"
        className="hero-video-iframe"
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
    </div>
  );
}
