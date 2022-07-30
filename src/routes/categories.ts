import express from "express";
import { categorySchema } from "../middlewares/validations";

import {
  getAllCategory,
  createNewCategory,
  getCategoryById,
  deleteCategory,
  updateCategory,
} from "../controllers/categories";

import { isAuthenticated } from "../middlewares/auth";

const router = express.Router();

router.get("/categories", getAllCategory);
router.get("/categories/:id", getCategoryById);
router.post(
  "/categories",
  isAuthenticated,
  ...categorySchema,
  createNewCategory
);
router.put(
  "/categories/:id",
  isAuthenticated,
  ...categorySchema,
  updateCategory
);
router.delete("/categories/:id", isAuthenticated, deleteCategory);

export default router;
