import express from "express";
import { categorySchema } from "../middlewares/validations";

import {
  getAllCategory,
  createNewCategory,
  getCategoryById,
  deleteCategory,
  updateCategory,
} from "../controllers/categories";

const router = express.Router();

router.get("/categories", getAllCategory);
router.get("/categories/:id", getCategoryById);
router.post("/categories", ...categorySchema, createNewCategory);
router.put("/categories/:id", ...categorySchema, updateCategory);
router.delete("/categories/:id", deleteCategory);

export default router;
