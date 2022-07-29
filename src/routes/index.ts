import express, { Express } from "express";

import products from "./product";

const router = express.Router();

const useRoutes = () => {
  router.get("/", (req, res) =>
    res
      .status(200)
      .json({ status: 200, message: "Welcome to sahaba NFT marketplace" })
  );
  router.use(products);

  return router;
};

export { useRoutes };
