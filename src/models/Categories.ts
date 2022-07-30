import prisma from "../constant/prisma";

const create = async (payload: Category): Promise<Category> => {
  try {
    const category = await prisma.categories.create({
      data: { name: payload.name },
    });
    return category as Category;
  } catch (err) {
    throw err;
  }
};

const getAll = async (): Promise<Category[]> => {
  try {
    const categories = (await prisma.categories.findMany({
      orderBy: {
        id: "desc",
      },
    })) as Category[];
    return categories;
  } catch (err) {
    throw err;
  }
};

const getById = async (id: number): Promise<Category | null> => {
  try {
    const category = (await prisma.categories.findUnique({
      where: {
        id,
      },
    })) as Category | null;
    return category;
  } catch (err) {
    throw err;
  }
};

const update = async (id: number, payload: Category): Promise<Category> => {
  try {
    const category = (await prisma.categories.update({
      where: {
        id,
      },
      data: payload,
    })) as Category;
    return category;
  } catch (err) {
    throw err;
  }
};

const drop = async (id: number): Promise<boolean> => {
  try {
    await prisma.categories.delete({
      where: { id },
    });
    return true;
  } catch (err) {
    throw err;
  }
};

export { create, getById, getAll, drop, update };
