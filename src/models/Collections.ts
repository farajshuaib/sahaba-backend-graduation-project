import { prisma } from "../constant";

const create = async (payload: Collection): Promise<Collection> => {
  try {
    const collection = await prisma.collections.create({
      data: payload,
    });
    return collection as Collection;
  } catch (err) {
    throw err;
  }
};

const getAll = async (): Promise<Collection[]> => {
  try {
    const collections = (await prisma.collections.findMany({
      orderBy: {
        id: "desc",
      },
    })) as Collection[];
    return collections;
  } catch (err) {
    throw err;
  }
};

const getById = async (id: number): Promise<Collection | null> => {
  try {
    const collection = (await prisma.collections.findUnique({
      where: {
        id,
      },
    })) as Collection | null;
    return collection;
  } catch (err) {
    throw err;
  }
};

const update = async (id: number, payload: Collection): Promise<Collection> => {
  try {
    const collection = (await prisma.collections.update({
      where: {
        id,
      },
      data: payload,
    })) as Collection;
    return collection;
  } catch (err) {
    throw err;
  }
};

const drop = async (id: number): Promise<boolean> => {
  try {
    await prisma.collections.delete({
      where: { id },
    });
    return true;
  } catch (err) {
    throw err;
  }
};

export { create, getById, getAll, drop, update };
