import { prisma } from "../constant";

const create = async (payload: Product): Promise<Product> => {
  try {
    const product = await prisma.products.create({
      data: payload,
    });
    return product as Product;
  } catch (err) {
    throw err;
  }
};

const getAll = async (): Promise<Product[]> => {
  try {
    const products = (await prisma.products.findMany({
      orderBy: {
        id: "desc",
      },
    })) as Product[];
    return products;
  } catch (err) {
    throw err;
  }
};

const getById = async (id: number): Promise<Product | null> => {
  try {
    const product = (await prisma.products.findUnique({
      where: {
        id,
      },

    })) as Product | null;
    return product;
  } catch (err) {
    throw err;
  }
};

const update = async (id: number, payload: Product): Promise<Product> => {
  try {
    const product = (await prisma.products.update({
      where: {
        id,
      },
      data: payload,
    })) as Product;
    return product;
  } catch (err) {
    throw err;
  }
};

const drop = async (id: number): Promise<boolean> => {
  try {
    await prisma.products.delete({
      where: { id },
    });
    return true;
  } catch (err) {
    throw err;
  }
};

export { create, getById, getAll, drop, update };
