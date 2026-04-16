export default function HeroVideo() {
  return (
    <div className="absolute inset-0 overflow-hidden pointer-events-none bg-ibk-dark-deep">
      <video
        autoPlay
        muted
        loop
        playsInline
        preload="metadata"
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
        <source src="/assets/video/hero.mp4" type="video/mp4" />
      </video>
    </div>
  );
}
