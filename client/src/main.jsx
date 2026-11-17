import React from "react";
import { createRoot } from "react-dom/client";
import { RoomsList } from "./app.jsx";

createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <RoomsList apiUrl="/api/rooms" />
  </React.StrictMode>
);
