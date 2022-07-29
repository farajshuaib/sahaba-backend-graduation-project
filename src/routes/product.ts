import express from "express";

import { uploadImage } from "../controllers/product";
import multerHandler from "../middlewares/multerHandler";

const router = express.Router();

router.post("/upload-item", multerHandler, uploadImage);

export default router;
