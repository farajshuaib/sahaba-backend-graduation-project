import { Request, Response } from "express";
import { create, getById, getAll, drop, update } from "../models/Categories";
import { validationResult } from "express-validator";

const getAllCategory = async (req: Request, res: Response) => {
  try {
    const categories = await getAll();
    res.status(200).json({ data: categories, message: "success" });
  } catch (error) {
    res.status(500).json({ message: "server error", error });
  }
};

const createNewCategory = async (req: Request, res: Response) => {
  const errors = validationResult(req);

  if (!errors.isEmpty()) {
    return res.status(400).json({
      errors: errors.array(),
      message: "Invalid argument (invalid request payload)",
    });
  }
  try {
    const category = await create(req.body);
    res
      .status(200)
      .json({ data: category, message: "category created successfully" });
  } catch (error: any) {
    res.status(500).json({
      message:
        error?.code === "P2002"
          ? "category already exist, you can't create category with same name"
          : "server error",
      error,
    });
  }
};

const getCategoryById = async (req: Request, res: Response) => {
  const id = req.params.id;
  if (!id) {
    return res.status(400).json({
      message: "Invalid argument (invalid request payload)",
    });
  }
  try {
    const category = await getById(+id);
    if (!category) {
      return res.status(404).json({
        message: "not found",
      });
    }
    res.status(200).json({ data: category, message: "success" });
  } catch (error) {
    res.status(500).json({ message: "server error", error });
  }
};

const deleteCategory = async (req: Request, res: Response) => {
  const id = req.params.id;
  if (!id) {
    return res.status(400).json({
      message:
        "Invalid argument, it's seems like you forgot to pass category id as a params.",
    });
  }
  try {
    await drop(+id);
    res.status(200).json({ message: "category deleted success" });
  } catch (error) {
    res.status(500).json({ message: "server error", error });
  }
};

const updateCategory = async (req: Request, res: Response) => {
  const id = req.params.id;
  const errors = validationResult(req);
  if (!id) {
    return res.status(400).json({
      message:
        "Invalid argument, it's seems like you forgot to pass category id as a params.",
    });
  }

  if (!errors.isEmpty()) {
    return res.status(400).json({
      errors: errors.array(),
      message: "Invalid argument (invalid request payload)",
    });
  }

  try {
    const category = await update(+id, req.body);
    if (!category) {
      return res.status(404).json({
        message: "not found",
      });
    }
    res.status(200).json({ data: category, message: "category updated successfully" });
  } catch (error) {
    res.status(500).json({ message: "server error", error });
  }
};

export {
  getAllCategory,
  createNewCategory,
  getCategoryById,
  deleteCategory,
  updateCategory,
};
