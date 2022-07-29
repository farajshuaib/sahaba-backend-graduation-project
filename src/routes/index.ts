import express, { Express } from "express";

import products from "./product";
import categories from "./categories";

const router = express.Router();

const useRoutes = () => {
  router.get("/", (req, res) =>
    res
      .status(200)
      .json({ statusCode: 200, message: "Welcome to sahaba NFT marketplace" })
  );
  router.use(products);
  router.use(categories);

  return router;
};

export { useRoutes };
